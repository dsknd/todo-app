<?php

namespace App\Repositories\Interfaces;

use App\Models\Project;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ValueObjects\CategoryId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

interface ProjectRepository
{
    /**
     * IDによってプロジェクトを検索します
     *
     * @param ProjectId $id
     * @return Project|null
     */
    public function findById(ProjectId $id): ?Project;

    /**
     * 複数のIDでプロジェクトを検索
     *
     * @param array<ProjectId> $projectIds
     * @return Collection
     */
    public function findByIds(array $projectIds): Collection;

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
     * @param ProjectId $projectId
     * @param array $attributes
     * @return bool
     */
    public function update(ProjectId $projectId, array $attributes): bool;

    /**
     * プロジェクトを削除
     *
     * @param ProjectId $projectId
     * @return bool
     */
    public function delete(ProjectId $projectId): bool;

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
     * 参加者IDによってプロジェクトを検索します
     *
     * @param UserId $userId
     * @return SupportCollection<int, Project>
     */
    public function findByParticipantId(UserId $userId): SupportCollection;
}