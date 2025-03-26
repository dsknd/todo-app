<?php

namespace App\Repositories\Interfaces;

use App\Models\ProjectPermission;
use App\ValueObjects\ProjectRoleId;
use App\ValueObjects\PermissionId;
use App\Models\ProjectRole;
use Illuminate\Support\Collection;
use App\Models\Permission;
interface ProjectPermissonRepository
{
    /**
     * プロジェクトロールの権限を取得
     *
     * @param PermissionId $permissionId
     * @return ProjectPermission
     */
    public function findById(PermissionId $permissionId): ProjectPermission;
}