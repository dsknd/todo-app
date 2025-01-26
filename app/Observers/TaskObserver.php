<?php

namespace App\Observers;

use App\Models\Task;
use App\Services\MilestoneProgressService;

class TaskObserver
{
    private MilestoneProgressService $progressService;

    public function __construct(MilestoneProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * タスクが更新された後の処理
     */
    public function updated(Task $task): void
    {
        // progressが変更された場合のみ処理を実行
        if ($task->isDirty('progress')) {
            $this->progressService->updateProgressForTask($task->id);
        }
    }
}