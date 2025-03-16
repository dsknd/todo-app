<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskPriority extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color',         // 優先度の表示色（例：#FF0000）
        'display_order', // 表示順序
        'weight',        // 優先度の重み（数値が大きいほど優先度が高い）
        'icon',          // アイコン名（例：'flag-high'）
        'is_default',    // デフォルトの優先度かどうか
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'display_order' => 'integer',
        'weight' => 'integer',
        'is_default' => 'boolean',
    ];

    /**
     * この優先度を持つタスクとの関連
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'priority_id');
    }

    /**
     * デフォルトの優先度を取得
     */
    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first();
    }

    /**
     * 優先度一覧を取得（表示順序でソート）
     * 
     * @return array<self>
     */
    public static function getAllPriorities(): array
    {
        return static::orderBy('display_order')
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

    /**
     * 優先度の重みを更新
     */
    public function updateWeight(int $newWeight): void
    {
        if ($newWeight < 0) {
            throw new \InvalidArgumentException('Weight cannot be negative');
        }

        $this->weight = $newWeight;
        $this->save();
    }

    /**
     * 優先度の比較
     * 
     * @return int -1: 自身の方が低い, 0: 同じ, 1: 自身の方が高い
     */
    public function compareTo(self $other): int
    {
        return $this->weight <=> $other->weight;
    }

    /**
     * 優先度が指定された優先度より高いかどうかを判定
     */
    public function isHigherThan(self $other): bool
    {
        return $this->weight > $other->weight;
    }

    /**
     * 優先度が指定された優先度より低いかどうかを判定
     */
    public function isLowerThan(self $other): bool
    {
        return $this->weight < $other->weight;
    }
}
