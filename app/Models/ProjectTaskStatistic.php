<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTaskStatistic extends Model
{
    protected $fillable = [
        'project_id',
        'task_id',
        'total_estimated_hours',    // 見積もり工数の合計
        'total_actual_hours',       // 実績工数の合計
        'progress',                 // 進捗率
        'delay_days',              // 遅延日数
        'child_count',             // 子タスク数
        'completed_child_count',    // 完了した子タスク数
        'blocked_count',           // ブロックされているタスク数
        'risk_level',              // リスクレベル（0-3）
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_estimated_hours' => 'decimal:2',
        'total_actual_hours' => 'decimal:2',
        'progress' => 'decimal:2',
        'delay_days' => 'integer',
        'child_count' => 'integer',
        'completed_child_count' => 'integer',
        'blocked_count' => 'integer',
        'risk_level' => 'integer',
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
     * 統計情報を更新
     */
    public function updateStatistics(): void
    {
        $this->updateHours();
        $this->updateProgress();
        $this->updateDelayDays();
        $this->updateChildCounts();
        $this->updateBlockedCount();
        $this->updateRiskLevel();
        $this->save();
    }

    /**
     * 工数情報を更新
     */
    private function updateHours(): void
    {
        $this->total_estimated_hours = $this->calculateTotalEstimatedHours();
        $this->total_actual_hours = $this->calculateTotalActualHours();
    }

    /**
     * 進捗率を更新
     */
    private function updateProgress(): void
    {
        $this->progress = $this->calculateProgress();
    }

    /**
     * 遅延日数を更新
     */
    private function updateDelayDays(): void
    {
        $this->delay_days = $this->calculateDelayDays();
    }

    /**
     * 子タスク数を更新
     */
    private function updateChildCounts(): void
    {
        $this->child_count = TaskClosure::where('ancestor_id', $this->task_id)
            ->where('depth', 1)
            ->count();

        $this->completed_child_count = TaskClosure::where('ancestor_id', $this->task_id)
            ->where('depth', 1)
            ->whereHas('descendant', function ($query) {
                $query->whereHas('status', function ($q) {
                    $q->where('is_completed', true);
                });
            })
            ->count();
    }

    /**
     * ブロックされているタスク数を更新
     */
    private function updateBlockedCount(): void
    {
        $this->blocked_count = TaskRelationship::where('target_task_id', $this->task_id)
            ->where('relationship_type', TaskRelationship::TYPE_BLOCKS)
            ->count();
    }

    /**
     * リスクレベルを更新
     */
    private function updateRiskLevel(): void
    {
        $this->risk_level = $this->calculateRiskLevel();
    }

    /**
     * 合計見積もり工数を計算
     */
    private function calculateTotalEstimatedHours(): float
    {
        return TaskClosure::where('ancestor_id', $this->task_id)
            ->with('descendant')
            ->get()
            ->sum(fn ($closure) => $closure->descendant->estimated_hours ?? 0);
    }

    /**
     * 合計実績工数を計算
     */
    private function calculateTotalActualHours(): float
    {
        return TaskClosure::where('ancestor_id', $this->task_id)
            ->with('descendant')
            ->get()
            ->sum(fn ($closure) => $closure->descendant->actual_hours ?? 0);
    }

    /**
     * 進捗率を計算
     */
    private function calculateProgress(): float
    {
        $tasks = TaskClosure::where('ancestor_id', $this->task_id)
            ->with(['descendant', 'descendant.status'])
            ->get();

        if ($tasks->isEmpty()) {
            return 0;
        }

        $totalWeight = $tasks->sum(fn ($closure) => $closure->descendant->weight ?? 1);
        $totalProgress = $tasks->sum(fn ($closure) => 
            ($closure->descendant->progress ?? 0) * ($closure->descendant->weight ?? 1)
        );

        return $totalWeight > 0 ? ($totalProgress / $totalWeight) : 0;
    }

    /**
     * 遅延日数を計算
     */
    private function calculateDelayDays(): int
    {
        if (!$this->task->planned_end_date) {
            return 0;
        }

        if ($this->task->actual_end_date) {
            return max(0, $this->task->actual_end_date->diffInDays($this->task->planned_end_date));
        }

        return max(0, now()->diffInDays($this->task->planned_end_date));
    }

    /**
     * リスクレベルを計算
     */
    private function calculateRiskLevel(): int
    {
        $score = 0;

        // 遅延による加点
        if ($this->delay_days > 0) {
            $score += min(3, intdiv($this->delay_days, 7));
        }

        // ブロックによる加点
        if ($this->blocked_count > 0) {
            $score += min(2, $this->blocked_count);
        }

        // 進捗遅れによる加点
        $expectedProgress = $this->calculateExpectedProgress();
        if ($this->progress < $expectedProgress - 20) {
            $score += 2;
        } elseif ($this->progress < $expectedProgress - 10) {
            $score += 1;
        }

        return min(3, $score);
    }

    /**
     * 期待される進捗率を計算
     */
    private function calculateExpectedProgress(): float
    {
        if (!$this->task->planned_start_date || !$this->task->planned_end_date) {
            return 0;
        }

        $totalDays = $this->task->planned_start_date->diffInDays($this->task->planned_end_date);
        if ($totalDays === 0) {
            return 100;
        }

        $elapsedDays = $this->task->planned_start_date->diffInDays(now());
        return min(100, ($elapsedDays / $totalDays) * 100);
    }
}
