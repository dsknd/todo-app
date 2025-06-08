<?php

namespace App\Repositories;

use App\Models\ProjectMember;
use App\Repositories\Interfaces\ProjectMemberRepository as ProjectMemberRepositoryInterface;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectRoleId;
use Illuminate\Support\Facades\DB;
use DateTimeImmutable;
use App\Models\ProjectRole;
use App\ValueObjects\PermissionId;

class EloquentProjectMemberRepository implements ProjectMemberRepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function exists(ProjectId $projectId, UserId $userId): bool
    {
        return ProjectMember::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * @inheritDoc
     */
    public function add(ProjectId $projectId, UserId $userId, ProjectRoleId $projectRoleId, ?DateTimeImmutable $joinedAt = null): bool
    {
        // すでにメンバーの場合は追加しない
        if ($this->exists($projectId, $userId)) {
            return false;
        }

        // ロールIDが指定されている場合はロールを取得
        if ($projectRoleId) {
            $role = ProjectRole::find($projectRoleId);
            if (!$role) {
                return false;
            }
        }

        // 属性を設定
        $attributes = [
            'project_id' => $projectId,
            'user_id' => $userId,
            'role_id' => $projectRoleId,
            'joined_at' => $joinedAt ?? now(),
        ];

        // メンバーを追加
        $projectMember = ProjectMember::create($attributes);
        
        return $projectMember !== null;
    }

    /**
     * @inheritDoc
     */
    public function update(ProjectId $projectId, UserId $userId, ProjectRoleId $projectRoleId, array $attributes): bool
    {
        if (!$this->exists($projectId, $userId)) {
            return false;
        }

        // 中間テーブルの属性を更新
        return DB::table('project_members')
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->where('role_id', $projectRoleId)
            ->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function remove(ProjectId $projectId, UserId $userId): bool
    {
        if (!$this->exists($projectId, $userId)) {
            return false;
        }

        // メンバーを削除
        return ProjectMember::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * @inheritDoc
     */
    public function hasRole(ProjectId $projectId, UserId $userId, ProjectRoleId $projectRoleId): bool
    {
        return ProjectMember::where('project_id', $projectId)
            ->where('user_id', $userId)
            ->where('role_id', $projectRoleId)
            ->exists();
    }

    /**
     * @inheritDoc
     */
    public function hasPermission(UserId $userId, ProjectId $projectId, PermissionId $permissionId): bool
    {
        return ProjectMember::query()
            ->where('user_id', $userId->getValue())
            ->where('project_id', $projectId->getValue())
            ->whereHas('role.permissions', function ($query) use ($permissionId) {
                $query->where('id', $permissionId->getValue());
            })
            ->exists();
    }
}