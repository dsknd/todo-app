<?php

namespace App\Repositories\Interfaces;

use App\Models\ProjectRole;
use App\ValueObjects\ProjectId;
use App\ValueObjects\ProjectRoleId;
use App\ValueObjects\ProjectRoleTypeId;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\ValueObjects\ProjectRoleNumber;
interface ProjectRoleRepository
{
    /**
     * IDでプロジェクトロールを検索
     *
     * @param ProjectRoleId $projectRoleId
     * @return ProjectRole|null
     */
    public function findById(ProjectRoleId $projectRoleId): ?ProjectRole;

    /**
     * プロジェクトIDとロール番号でプロジェクトロールを検索
     *
     * @param ProjectId $projectId
     * @param ProjectRoleNumber $roleNumber
     * @return ProjectRole|null
     */
    public function findByProjectIdAndRoleNumber(ProjectId $projectId, ProjectRoleNumber $roleNumber): ?ProjectRole;

    /**
     * プロジェクトIDに関連するすべてのロールを取得
     *
     * @param ProjectId $projectId
     * @return Collection
     */
    public function findAllByProjectId(ProjectId $projectId): Collection;

    /**
     * プロジェクトIDに関連するロールをページネーションで取得
     *
     * @param ProjectId $projectId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function findByProjectIdPaginated(ProjectId $projectId, int $perPage = 15): LengthAwarePaginator;
} 