<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskStatus extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color',         // ステータスの表示色（例：#FF0000）
        'display_order', // 表示順序
        'is_default',    // デフォルトステータスかどうか
        'is_completed',  // 完了状態を表すかどうか
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
        'is_completed' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * このステータスを持つタスクとの関連
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'status_id');
    }

    /**
     * デフォルトのタスクステータスを取得
     */
    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first();
    }

    /**
     * 完了状態のタスクステータスを取得
     * 
     * @return array<self> 完了状態を表すステータスの配列
     */
    public static function getCompletedStatuses(): array
    {
        return static::where('is_completed', true)
            ->orderBy('display_order')
            ->get()
            ->all();
    }

    /**
     * 表示順序を更新
     */
    public function updateDisplayOrder(int $newOrder): void
    {
        if ($newOrder === $this->display_order) {
            return;
        }

        if ($newOrder < $this->display_order) {
            // 上に移動する場合
            static::where('display_order', '>=', $newOrder)
                ->where('display_order', '<', $this->display_order)
                ->increment('display_order');
        } else {
            // 下に移動する場合
            static::where('display_order', '>', $this->display_order)
                ->where('display_order', '<=', $newOrder)
                ->decrement('display_order');
        }

        $this->display_order = $newOrder;
        $this->save();
    }
}
