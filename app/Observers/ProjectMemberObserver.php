<?php

namespace App\Observers;

use App\Models\ProjectMember;
use App\Models\Project;

class ProjectMemberObserver
{
    /**
     * メンバーが追加された後の処理
     */
    public function created(ProjectMember $projectMember): void
    {
        $this->updateMemberCount($projectMember->project_id);
    }

    /**
     * メンバーが削除された後の処理
     */
    public function deleted(ProjectMember $projectMember): void
    {
        $this->updateMemberCount($projectMember->project_id);
    }

    /**
     * プロジェクトのメンバー数を更新
     */
    private function updateMemberCount(int $projectId): void
    {
        Project::where('id', $projectId)->update([
            'member_count' => ProjectMember::where('project_id', $projectId)->count()
        ]);
    }
}