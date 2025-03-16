<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProjectTask extends Pivot
{
    protected $table = 'project_tasks';

    protected $fillable = [
        'project_id',
        'task_id',
        'display_order',
        'project_wbs_number',
        'weight',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'display_order' => 'integer',
        'weight' => 'decimal:2',
    ];

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
     * WBS番号を生成
     * 
     * @param string|null $parentWbs 親のWBS番号
     * @param int $sequence 同階層での順番
     */
    public function generateWbsNumber(?string $parentWbs, int $sequence): void
    {
        $this->project_wbs_number = $parentWbs
            ? $parentWbs . '.' . $sequence
            : (string)$sequence;
        
        $this->save();
    }

    /**
     * WBS番号から階層レベルを取得
     */
    public function getWbsLevel(): int
    {
        return $this->project_wbs_number
            ? substr_count($this->project_wbs_number, '.') + 1
            : 0;
    }

    /**
     * 同じプロジェクト内の次の表示順序を取得
     */
    public function getNextDisplayOrder(): int
    {
        return static::where('project_id', $this->project_id)
            ->max('display_order') + 1;
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
            static::where('project_id', $this->project_id)
                ->where('display_order', '>=', $newOrder)
                ->where('display_order', '<', $this->display_order)
                ->increment('display_order');
        } else {
            // 下に移動する場合
            static::where('project_id', $this->project_id)
                ->where('display_order', '>', $this->display_order)
                ->where('display_order', '<=', $newOrder)
                ->decrement('display_order');
        }

        $this->display_order = $newOrder;
        $this->save();
    }

    /**
     * 重みを更新
     */
    public function updateWeight(float $newWeight): void
    {
        if ($newWeight <= 0) {
            throw new \InvalidArgumentException('Weight must be positive');
        }

        $this->weight = $newWeight;
        $this->save();
    }
}
