<?php

namespace App\Services;

use App\Models\ProjectMilestone;
use Illuminate\Support\Facades\DB;

class MilestoneProgressService
{
    /**
     * マイルストーンの進捗率を更新
     */
    public function updateProgress(int $milestoneId): void
    {
        $progress = DB::table('milestone_tasks as mt')
            ->join('tasks as t', 'mt.task_id', '=', 't.id')
            ->where('mt.milestone_id', $milestoneId)
            ->select(DB::raw('COALESCE(SUM(t.progress * mt.weight) / NULLIF(SUM(mt.weight), 0), 0) as progress'))
            ->value('progress');

        ProjectMilestone::where('id', $milestoneId)->update([
            'progress' => $progress
        ]);
    }

    /**
     * タスクに関連するすべてのマイルストーンの進捗を更新
     */
    public function updateProgressForTask(int $taskId): void
    {
        $milestoneIds = DB::table('milestone_tasks')
            ->where('task_id', $taskId)
            ->pluck('milestone_id');

        foreach ($milestoneIds as $milestoneId) {
            $this->updateProgress($milestoneId);
        }
    }
}