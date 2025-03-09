<?php

namespace App\Repositories\Interfaces;

use App\Models\ProjectRole;
use App\ValueObjects\ProjectRoleId;

interface ProjectRoleRepository
{
    /**
     * IDでプロジェクトロールを検索
     *
     * @param ProjectRoleId $projectRoleId
     * @return ProjectRole|null
     */
    public function findById(ProjectRoleId $projectRoleId): ?ProjectRole;
} 