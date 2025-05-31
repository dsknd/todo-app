<?php

namespace App\Repositories\Interfaces;

use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectRoleId;
use DateTimeImmutable;

interface ProjectMemberRepository
{

    /**
     * プロジェクトメンバーが存在するか確認
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @return bool
     */
    public function exists(ProjectId $projectId, UserId $userId): bool;

    /**
     * プロジェクトメンバーを追加
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @param ProjectRoleId $projectRoleId
     * @param DateTimeImmutable|null $joinedAt
     * @return bool
     */
    public function add(ProjectId $projectId, UserId $userId, ProjectRoleId $projectRoleId, ?DateTimeImmutable $joinedAt = null): bool;

    /**
     * プロジェクトメンバーを更新
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @param ProjectRoleId $projectRoleId
     * @param array $attributes
     * @return bool
     */
    public function update(ProjectId $projectId, UserId $userId, ProjectRoleId $projectRoleId, array $attributes): bool;

    /**
     * プロジェクトメンバーを削除
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @return bool
     */
    public function remove(ProjectId $projectId, UserId $userId): bool;

    /**
     * プロジェクトメンバーが特定のロールを持っているか確認
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function hasRole(ProjectId $projectId, UserId $userId, ProjectRoleId $projectRoleId): bool;

}