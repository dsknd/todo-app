<?php

namespace App\Observers;

use App\Models\MilestoneTask;
use App\Services\MilestoneProgressService;

class MilestoneTaskObserver
{
    private MilestoneProgressService $progressService;

    public function __construct(MilestoneProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * タスクが追加された後の処理
     */
    public function created(MilestoneTask $milestoneTask): void
    {
        $this->progressService->updateProgress($milestoneTask->milestone_id);
    }

    /**
     * タスクが更新された後の処理
     */
    public function updated(MilestoneTask $milestoneTask): void
    {
        $this->progressService->updateProgress($milestoneTask->milestone_id);
    }

    /**
     * タスクが削除された後の処理
     */
    public function deleted(MilestoneTask $milestoneTask): void
    {
        $this->progressService->updateProgress($milestoneTask->milestone_id);
    }
}