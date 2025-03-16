<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskRelationship extends Model
{
    protected $fillable = [
        'source_task_id',      // 関係元のタスクID
        'target_task_id',      // 関係先のタスクID
        'relationship_type',    // 関係タイプ（related, blocks, duplicates など）
        'description',         // 関係の説明
        'created_by',          // 関係を作成したユーザーID
    ];

    /**
     * 関係タイプの定義
     */
    public const TYPE_RELATED = 'related';         // 関連
    public const TYPE_BLOCKS = 'blocks';           // ブロック
    public const TYPE_BLOCKED_BY = 'blocked_by';   // ブロックされる
    public const TYPE_DUPLICATES = 'duplicates';   // 複製
    public const TYPE_CLONES = 'clones';           // クローン

    /**
     * 関係元のタスクとの関連
     */
    public function sourceTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'source_task_id');
    }

    /**
     * 関係先のタスクとの関連
     */
    public function targetTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'target_task_id');
    }

    /**
     * 作成者との関連
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * 関係タイプの一覧を取得
     * 
     * @return array<string, string> キー：関係タイプ、値：説明
     */
    public static function getRelationshipTypes(): array
    {
        return [
            self::TYPE_RELATED => '関連',
            self::TYPE_BLOCKS => 'ブロック',
            self::TYPE_BLOCKED_BY => 'ブロックされる',
            self::TYPE_DUPLICATES => '複製',
            self::TYPE_CLONES => 'クローン',
        ];
    }

    /**
     * 逆の関係タイプを取得
     */
    public static function getOppositeType(string $type): string
    {
        return match($type) {
            self::TYPE_BLOCKS => self::TYPE_BLOCKED_BY,
            self::TYPE_BLOCKED_BY => self::TYPE_BLOCKS,
            self::TYPE_DUPLICATES => self::TYPE_DUPLICATES,
            self::TYPE_CLONES => self::TYPE_CLONES,
            default => self::TYPE_RELATED,
        };
    }

    /**
     * 関係の検証
     * 
     * @throws \InvalidArgumentException 検証エラーの場合
     */
    public function validate(): void
    {
        // 同じタスク同士の関係は不可
        if ($this->source_task_id === $this->target_task_id) {
            throw new \InvalidArgumentException('Cannot create relationship between same task');
        }

        // 関係タイプが有効か確認
        if (!array_key_exists($this->relationship_type, self::getRelationshipTypes())) {
            throw new \InvalidArgumentException('Invalid relationship type');
        }

        // 作成者が存在することを確認
        if (!$this->creator) {
            throw new \InvalidArgumentException('Creator does not exist');
        }

        // 循環ブロックの確認
        if ($this->relationship_type === self::TYPE_BLOCKS) {
            $this->validateBlockingCycle();
        }
    }

    /**
     * ブロック関係の循環を確認
     * 
     * @throws \InvalidArgumentException 循環が存在する場合
     */
    private function validateBlockingCycle(): void
    {
        $visited = [$this->source_task_id];
        $current = $this->target_task_id;

        while ($current) {
            if (in_array($current, $visited)) {
                throw new \InvalidArgumentException('Circular blocking relationship detected');
            }

            $visited[] = $current;
            $next = static::where('source_task_id', $current)
                ->where('relationship_type', self::TYPE_BLOCKS)
                ->value('target_task_id');

            $current = $next;
        }
    }
}
