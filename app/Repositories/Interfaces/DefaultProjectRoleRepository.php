<?php

namespace App\Repositories\Interfaces;

use App\Models\DefaultProjectRole;
use App\ValueObjects\ProjectRoleId;
use Illuminate\Support\Collection;

interface DefaultProjectRoleRepository
{
    /**
     * プロジェクトロールIDでデフォルトプロジェクトロールを検索
     *
     * @param ProjectRoleId $projectRoleId
     * @return DefaultProjectRole|null
     */
    public function findByProjectRoleId(ProjectRoleId $projectRoleId): ?DefaultProjectRole;

    /**
     * すべてのデフォルトプロジェクトロールを取得
     *
     * @return Collection
     */
    public function findAll(): Collection;
} 