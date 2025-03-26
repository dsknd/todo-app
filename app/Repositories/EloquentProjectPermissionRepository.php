<?php

namespace App\Repositories;

use App\Models\ProjectPermission;
use App\Repositories\Interfaces\ProjectPermissonRepository;
use App\ValueObjects\PermissionId;

class EloquentProjectPermissionRepository implements ProjectPermissonRepository
{
    /**
     * プロジェクトロールの権限を取得
     *
     * @param PermissionId $permissionId
     * @return ProjectPermission
     */
    public function findById(PermissionId $permissionId): ProjectPermission
    {
        return ProjectPermission::findOrFail($permissionId);
    }
}