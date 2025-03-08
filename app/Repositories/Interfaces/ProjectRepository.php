<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ValueObjects\CategoryId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProjectRepository
{
    /**
     * IDでプロジェクトを検索
     *
     * @param ProjectId $id
     * @return Project|null
     */
    public function findById(ProjectId $id): ?Project;

    /**
     * 複数のIDでプロジェクトを検索
     *
     * @param array<ProjectId> $ids
     * @return Collection
     */
    public function findByIds(array $ids): Collection;

    /**
     * ユーザーIDでプロジェクトを検索
     *
     * @param UserId $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function findByUserId(UserId $userId, int $perPage = 15): LengthAwarePaginator;

    /**
     * ユーザーが参加しているプロジェクトを検索
     *
     * @param UserId $userId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function findByMemberId(UserId $userId, int $perPage = 15): LengthAwarePaginator;

    /**
     * プロジェクトを作成
     *
     * @param array $attributes
     * @return Project
     */
    public function create(array $attributes): Project;

    /**
     * プロジェクトを更新
     *
     * @param ProjectId $id
     * @param array $attributes
     * @return bool
     */
    public function update(ProjectId $id, array $attributes): bool;

    /**
     * プロジェクトを削除
     *
     * @param ProjectId $id
     * @return bool
     */
    public function delete(ProjectId $id): bool;

    /**
     * ユーザーがプロジェクトにアクセスできるかどうかを確認
     *
     * @param UserId $userId
     * @param ProjectId $projectId
     * @return bool
     */
    public function canUserAccessProject(UserId $userId, ProjectId $projectId): bool;

    /**
     * ユーザーがプロジェクトを編集できるかどうかを確認
     *
     * @param UserId $userId
     * @param ProjectId $projectId
     * @return bool
     */
    public function canUserEditProject(UserId $userId, ProjectId $projectId): bool;

    /**
     * プロジェクトの進捗状況を更新
     *
     * @param ProjectId $id
     * @return bool
     */
    public function updateProgress(ProjectId $id): bool;

    /**
     * プロジェクトにメンバーを追加
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @param array $attributes
     * @return bool
     */
    public function addMember(ProjectId $projectId, UserId $userId, array $attributes = []): bool;

    /**
     * プロジェクトからメンバーを削除
     *
     * @param ProjectId $projectId
     * @param UserId $userId
     * @return bool
     */
    public function removeMember(ProjectId $projectId, UserId $userId): bool;
}