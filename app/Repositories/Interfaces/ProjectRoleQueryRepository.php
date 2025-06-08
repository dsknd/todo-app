<?php

namespace App\Repositories\Interfaces;

use App\ValueObjects\ProjectRoleId;
use App\ReadModels\ProjectRoleReadModel;
use App\ValueObjects\ProjectId;
use Illuminate\Support\Collection;
use App\ValueObjects\LocaleCode;

interface ProjectRoleQueryRepository
{
    /**
     * プロジェクトロールを取得します
     *
     * @param ProjectRoleId $projectRoleId
     * @return ProjectRoleReadModel
     */
    public function find(ProjectRoleId $projectRoleId, LocaleCode $localeCode): ProjectRoleReadModel;

    /**
     * プロジェクトIDでプロジェクトロールを取得します
     *
     * @param ProjectId $projectId
     * @return Collection<ProjectRoleReadModel>
     */
    public function getByProjectId(ProjectId $projectId, LocaleCode $localeCode): Collection;
}