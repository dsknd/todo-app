<?php

namespace App\Repositories\Interfaces;

use App\ValueObjects\ProjectRoleTypeId;
use App\ReadModels\ProjectRoleTypeReadModel;
use Illuminate\Support\Collection;
use App\ValueObjects\LocaleCode;

interface ProjectRoleTypeQueryRepository
{
    /**
     * プロジェクトロールタイプを取得
     *
     * @param ProjectRoleTypeId $projectRoleTypeId
     * @return ProjectRoleTypeReadModel
     */
    public function find(ProjectRoleTypeId $projectRoleTypeId, LocaleCode $localeCode): ProjectRoleTypeReadModel;

    /**
     * すべてのプロジェクトロールタイプを取得
     *
     * @param LocaleCode $localeCode
     * @return Collection<ProjectRoleTypeReadModel>
     */
    public function get(LocaleCode $localeCode): Collection;
}