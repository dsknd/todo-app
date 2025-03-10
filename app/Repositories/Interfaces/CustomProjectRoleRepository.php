<?php

namespace App\Repositories\Interfaces;

use App\Models\CustomProjectRole;
use App\ValueObjects\ProjectId;
use App\ValueObjects\ProjectRoleId;
use App\ValueObjects\ProjectRoleNumber;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CustomProjectRoleRepository
{
    /**
     * プロジェクトロールIDでカスタムプロジェクトロールを検索
     *
     * @param ProjectRoleId $projectRoleId
     * @return CustomProjectRole|null
     */
    public function findByProjectRoleId(ProjectRoleId $projectRoleId): ?CustomProjectRole;

    /**
     * プロジェクトIDとロール番号でカスタムプロジェクトロールを検索
     *
     * @param ProjectId $projectId
     * @param ProjectRoleNumber $roleNumber
     * @return CustomProjectRole|null
     */
    public function findByProjectIdAndRoleNumber(ProjectId $projectId, ProjectRoleNumber $roleNumber): ?CustomProjectRole;

    /**
     * プロジェクトIDに関連するすべてのカスタムロールを取得
     *
     * @param ProjectId $projectId
     * @return Collection
     */
    public function findAllByProjectId(ProjectId $projectId): Collection;

    /**
     * プロジェクトIDに関連するカスタムロールをページネーションで取得
     *
     * @param ProjectId $projectId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function findByProjectIdPaginated(ProjectId $projectId, int $perPage = 15): LengthAwarePaginator;

    /**
     * カスタムプロジェクトロールを作成
     *
     * @param ProjectRoleId $projectRoleId
     * @param array $attributes
     * @return CustomProjectRole
     */
    public function create(ProjectRoleId $projectRoleId, array $attributes): CustomProjectRole;

    /**
     * カスタムプロジェクトロールを更新
     *
     * @param ProjectRoleId $projectRoleId
     * @param array $attributes
     * @return bool
     */
    public function update(ProjectRoleId $projectRoleId, array $attributes): bool;

    /**
     * カスタムプロジェクトロールを削除
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function delete(ProjectRoleId $projectRoleId): bool;

    /**
     * カスタムプロジェクトロールが存在するかどうかを確認
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function exists(ProjectRoleId $projectRoleId): bool;

    /**
     * プロジェクトロールがカスタムロールかどうかを確認
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function isCustomRole(ProjectRoleId $projectRoleId): bool;

    /**
     * カスタムプロジェクトロールが削除可能かどうかを確認
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function isDeletable(ProjectRoleId $projectRoleId): bool;
} 