<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use App\Repositories\Interfaces\ProjectMemberRepository as ProjectMemberRepositoryInterface;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectRoleId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use DateTimeImmutable;
use App\Models\ProjectRole;
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
    public function add(ProjectId $projectId, UserId $userId, ?ProjectRoleId $roleId = null, ?DateTimeImmutable $joinedAt = null): bool
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

        // ロールIDが指定されている場合はロールを取得
        if ($roleId) {
            $role = ProjectRole::find($roleId->getValue());
            if (!$role) {
                return false;
            }
        }

        // 属性を設定
        $attributes = [
            'role_id' => $roleId,
            'joined_at' => $joinedAt ?? now(),
        ];
        
        // ロールIDが指定されている場合は追加
        if ($roleId) {
            $attributes['role_id'] = $roleId->getValue();
        }

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
    public function setRole(ProjectId $projectId, UserId $userId, ProjectRoleId $roleId): bool
    {
        $member = $this->findByProjectIdAndUserId($projectId, $userId);

        if (!$member) {
            return false;
        }

        // ロールを設定
        return $this->update($projectId, $userId, ['role_id' => $roleId]);
    }

    /**
     * @inheritDoc
     */
    public function removeRole(ProjectId $projectId, UserId $userId): bool
    {
        $member = $this->findByProjectIdAndUserId($projectId, $userId);

        if (!$member) {
            return false;
        }

        // ロールを削除（NULLに設定）
        return $this->update($projectId, $userId, ['role_id' => null]);
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

        // ロールが設定されていない場合はfalse
        if (!$member->role_id) {
            return false;
        }

        // ロール名を比較
        return $member->role->name === $roleName;
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

        // ロールが設定されていない場合は空配列
        if (!$member->role_id) {
            return [];
        }

        // ロールに関連する権限を取得
        return $member->role->projectPermissions->pluck('name')->toArray();
    }
}