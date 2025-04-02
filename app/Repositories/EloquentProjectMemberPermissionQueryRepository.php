<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProjectMemberPermissionQueryRepository;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ReadModels\ProjectMemberPermissionReadModel;
use App\Models\ProjectMember;
use Illuminate\Support\Collection;

class EloquentProjectMemberPermissionQueryRepository implements ProjectMemberPermissionQueryRepository
{
    /**
     * プロジェクトメンバーの権限情報を取得
     */
    public function findMemberPermissions(
        ProjectId $projectId,
        UserId $userId
    ): ProjectMemberPermissionReadModel {
        $permissions = $this->fetchMemberPermissions($projectId, $userId);
        
        return $this->createReadModel($projectId, $userId, $permissions);
    }

    /**
     * プロジェクトメンバーの権限情報をDBから取得
     */
    private function fetchMemberPermissions(ProjectId $projectId, UserId $userId): Collection
    {
        return ProjectMember::query()
            ->join('project_roles', 'project_members.role_id', '=', 'project_roles.id')
            ->join('project_role_permissions', 'project_roles.id', '=', 'project_role_permissions.project_role_id')
            ->join('project_permissions', 'project_role_permissions.project_permission_id', '=', 'project_permissions.permission_id')
            ->join('permissions', 'project_permissions.permission_id', '=', 'permissions.id')
            ->where('project_members.project_id', $projectId->getValue())
            ->where('project_members.user_id', $userId->getValue())
            ->select([
                'project_permissions.permission_id',
                'permissions.scope',
                'permissions.resource',
                'permissions.action'
            ])
            ->get();
    }

    /**
     * ReadModelの作成
     */
    private function createReadModel(
        ProjectId $projectId,
        UserId $userId,
        Collection $permissions
    ): ProjectMemberPermissionReadModel {
        return new ProjectMemberPermissionReadModel(
            $projectId,
            $userId,
            $permissions
        );
    }
}