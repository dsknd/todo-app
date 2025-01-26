<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectTaskAssignment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'task_id',
        'user_id',
        'assigned_by',          // 割り当てを行ったユーザーID
        'role',                 // 担当者の役割（responsible, accountable, consulted, informed）
        'start_date',          // 担当開始日
        'end_date',            // 担当終了日
        'estimated_hours',     // 見積もり工数
        'actual_hours',        // 実績工数
        'notes',               // 備考
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
    ];

    /**
     * 担当者の役割定義
     */
    public const ROLE_RESPONSIBLE = 'responsible';   // 実行責任者
    public const ROLE_ACCOUNTABLE = 'accountable';   // 説明責任者
    public const ROLE_CONSULTED = 'consulted';       // 助言者
    public const ROLE_INFORMED = 'informed';         // 情報共有先

    /**
     * プロジェクトとの関連
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * タスクとの関連
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * 担当者との関連
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 割り当てを行ったユーザーとの関連
     */
    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * 役割の一覧を取得
     * 
     * @return array<string, string> キー：役割、値：説明
     */
    public static function getRoles(): array
    {
        return [
            self::ROLE_RESPONSIBLE => '実行責任者',
            self::ROLE_ACCOUNTABLE => '説明責任者',
            self::ROLE_CONSULTED => '助言者',
            self::ROLE_INFORMED => '情報共有先',
        ];
    }

    /**
     * 割り当ての検証
     * 
     * @throws \InvalidArgumentException 検証エラーの場合
     */
    public function validate(): void
    {
        // 役割が有効か確認
        if (!array_key_exists($this->role, self::getRoles())) {
            throw new \InvalidArgumentException('Invalid role');
        }

        // 期間が有効か確認
        if ($this->start_date && $this->end_date && $this->start_date > $this->end_date) {
            throw new \InvalidArgumentException('Start date must be before end date');
        }

        // 工数が有効か確認
        if ($this->estimated_hours < 0 || $this->actual_hours < 0) {
            throw new \InvalidArgumentException('Hours cannot be negative');
        }

        // 説明責任者は1人のみ
        if ($this->role === self::ROLE_ACCOUNTABLE) {
            $exists = static::where('task_id', $this->task_id)
                ->where('role', self::ROLE_ACCOUNTABLE)
                ->where('id', '!=', $this->id)
                ->exists();

            if ($exists) {
                throw new \InvalidArgumentException('Task already has an accountable user');
            }
        }
    }

    /**
     * 割り当て期間が有効かどうかを確認
     */
    public function isActive(): bool
    {
        $now = now();
        
        if ($this->start_date && $now < $this->start_date) {
            return false;
        }

        if ($this->end_date && $now > $this->end_date) {
            return false;
        }

        return true;
    }

    /**
     * 実績工数を記録
     */
    public function logActualHours(float $hours, ?string $notes = null): void
    {
        $this->actual_hours += $hours;
        
        if ($notes) {
            $this->notes = $this->notes 
                ? $this->notes . "\n" . $notes
                : $notes;
        }

        $this->save();
    }
}