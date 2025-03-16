<?php

namespace App\Observers;

use App\Models\ProjectTask;
use App\Models\Project;

class ProjectTaskObserver
{
    /**
     * タスクが追加された後の処理
     */
    public function created(ProjectTask $projectTask): void
    {
        $this->updateTaskCount($projectTask->project_id);
    }

    /**
     * タスクが削除された後の処理
     */
    public function deleted(ProjectTask $projectTask): void
    {
        $this->updateTaskCount($projectTask->project_id);
    }

    /**
     * プロジェクトのタスク数を更新
     */
    private function updateTaskCount(int $projectId): void
    {
        Project::where('id', $projectId)->update([
            'task_count' => ProjectTask::where('project_id', $projectId)->count()
        ]);
    }
}