<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use App\Repositories\Interfaces\ProjectMemberRepository as ProjectMemberRepositoryInterface;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use DateTimeImmutable;

class EloquentProjectMemberRepository implements ProjectMemberRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findByProjectIdAndUserId(ProjectId $projectId, UserId $userId): ?ProjectMember
    {
        return ProjectMember::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function findByProjectId(ProjectId $projectId): Collection
    {
        return ProjectMember::where('project_id', $projectId)->get();
    }

    /**
     * @inheritDoc
     */
    public function findByUserId(UserId $userId): Collection
    {
        return ProjectMember::where('user_id', $userId)->get();
    }

    /**
     * @inheritDoc
     */
    public function add(ProjectId $projectId, UserId $userId, ?DateTimeImmutable $joinedAt): bool
    {
        // すでにメンバーの場合は追加しない
        if ($this->findByProjectIdAndUserId($projectId, $userId)) {
            return false;
        }

        // プロジェクトとユーザーが存在するか確認
        $project = Project::find($projectId->getValue());
        $user = User::find($userId->getValue());

        if (!$project || !$user) {
            return false;
        }

        // 属性にjoinedAtを追加
        $attributes['joined_at'] = $joinedAt ?? now();

        // メンバーを追加
        $project->members()->attach($userId->getValue(), $attributes);
        return true;
    }

    /**
     * @inheritDoc
     */
    public function update(ProjectId $projectId, UserId $userId, array $attributes): bool
    {
        $member = $this->findByProjectIdAndUserId($projectId, $userId);

        if (!$member) {
            return false;
        }

        // 中間テーブルの属性を更新
        return DB::table('project_members')
            ->where('project_id', $projectId->getValue())
            ->where('user_id', $userId->getValue())
            ->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function remove(ProjectId $projectId, UserId $userId): bool
    {
        $project = Project::find($projectId->getValue());

        if (!$project) {
            return false;
        }

        // メンバーを削除
        $affected = $project->members()->detach($userId->getValue());
        return $affected > 0;
    }

    /**
     * @inheritDoc
     */
    public function assignRoles(ProjectId $projectId, UserId $assigneeId, UserId $assignerId, array $roleIds): bool
    {
        $assignee = $this->findByProjectIdAndUserId($projectId, $assigneeId);
        $assigner = $this->findByProjectIdAndUserId($projectId, $assignerId);

        if (!$assignee || !$assigner) {
            return false;
        }

        // 各ロールIDに対してプロジェクトIDを含める
        $syncData = [];
        foreach ($roleIds as $roleId) {
            $syncData[$roleId] = [
                'project_id' => $projectId,
                'assigner_id' => $assigner->id,
                'assigned_at' => now(),
            ];
        }
        
        $assignee->projectRoles()->syncWithoutDetaching($syncData);
        return true;
    }

    /**
     * @inheritDoc
     */
    public function removeRoles(ProjectId $projectId, UserId $assigneeId, array $roleIds): bool
    {
        $assignee = $this->findByProjectIdAndUserId($projectId, $assigneeId);

        if (!$assignee) {
            return false;
        }

        // ロールの削除
        $assignee->projectRoles()
            ->wherePivot('project_id', $projectId)
            ->whereIn('project_role_id', $roleIds)
            ->detach();
            
        return true;
    }

    /**
     * @inheritDoc
     */
    public function hasPermission(ProjectId $projectId, UserId $userId, string $permission): bool
    {
        $member = $this->findByProjectIdAndUserId($projectId, $userId);

        if (!$member) {
            return false;
        }

        return $member->hasPermission($permission);
    }

    /**
     * @inheritDoc
     */
    public function hasRole(ProjectId $projectId, UserId $userId, string $roleName): bool
    {
        $member = $this->findByProjectIdAndUserId($projectId, $userId);

        if (!$member) {
            return false;
        }

        return $member->hasRole($roleName);
    }

    /**
     * @inheritDoc
     */
    public function getPermissions(ProjectId $projectId, UserId $userId): array
    {
        $member = $this->findByProjectIdAndUserId($projectId, $userId);

        if (!$member) {
            return [];
        }

        return $member->getPermissions();
    }
}