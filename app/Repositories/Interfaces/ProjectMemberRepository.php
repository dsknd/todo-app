<?php

namespace App\Repositories\Interfaces;

use App\ValueObjects\ProjectMemberOrderParamList;
use App\Models\ProjectMember;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectRoleId;
use Illuminate\Database\Eloquent\Collection;
use DateTimeImmutable;
use App\ValueObjects\PaginatorPageCount;
use App\ValueObjects\ProjectMemberNextToken;

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
     * プロジェクトIDでプロジェクトメンバーを検索
     *
     * @param ProjectId $projectId
     * @param PaginatorPageCount $pageCount
     * @param ProjectMemberOrderParamList $orderParamList
     * @return Collection
     */
    public function searchByProjectId(
        ProjectId $projectId,
        PaginatorPageCount $pageCount,
        ProjectMemberOrderParamList $orderParamList
    ): Collection;

    /**
     * NextTokenでプロジェクトメンバーを検索
     *
     * @param ProjectMemberNextToken $nextToken
     * @return Collection
     */
    public function searchByProjectIdWithNextToken(ProjectMemberNextToken $nextToken): Collection;

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