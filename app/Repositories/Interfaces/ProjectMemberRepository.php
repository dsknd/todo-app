<?php

namespace App\Repositories\Interfaces;

use App\Models\ProjectMember;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use Illuminate\Database\Eloquent\Collection;

interface ProjectMemberRepository
{
    /**
     * プロジェクトIDとユーザーIDでプロジェクトメンバーを検索
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @return ProjectMember|null
     */
    public function findByProjectIdAndUserId(ProjectId $projectId, UserId $userId): ?ProjectMember;

    /**
     * プロジェクトIDでプロジェクトメンバーを検索
     *
     * @param ProjectId $projectId
     * @return Collection
     */
    public function findByProjectId(ProjectId $projectId): Collection;

    /**
     * ユーザーIDでプロジェクトメンバーを検索
     *
     * @param UserId $userId
     * @return Collection
     */
    public function findByUserId(UserId $userId): Collection;

    /**
     * プロジェクトメンバーを追加
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @param array $attributes
     * @return bool
     */
    public function add(ProjectId $projectId, UserId $userId, array $attributes = []): bool;

    /**
     * プロジェクトメンバーを更新
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @param array $attributes
     * @return bool
     */
    public function update(ProjectId $projectId, UserId $userId, array $attributes): bool;

    /**
     * プロジェクトメンバーを削除
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @return bool
     */
    public function remove(ProjectId $projectId, UserId $userId): bool;

    /**
     * プロジェクトメンバーにロールを割り当て
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @param array $roleIds
     * @return bool
     */
    public function assignRoles(ProjectId $projectId, UserId $userId, array $roleIds): bool;

    /**
     * プロジェクトメンバーからロールを削除
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @param array $roleIds
     * @return bool
     */
    public function removeRoles(ProjectId $projectId, UserId $userId, array $roleIds): bool;

    /**
     * プロジェクトメンバーが特定の権限を持っているか確認
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @param string $permission
     * @return bool
     */
    public function hasPermission(ProjectId $projectId, UserId $userId, string $permission): bool;

    /**
     * プロジェクトメンバーが特定のロールを持っているか確認
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @param string $roleName
     * @return bool
     */
    public function hasRole(ProjectId $projectId, UserId $userId, string $roleName): bool;

    /**
     * プロジェクトメンバーの権限一覧を取得
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @return array<string>
     */
    public function getPermissions(ProjectId $projectId, UserId $userId): array;
}