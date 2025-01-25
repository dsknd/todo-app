<?php

namespace App\UseCases\Implementations;

use App\Enums\ProjectPermissions;
use App\Models\User;
use App\Models\Project;
use App\UseCases\CheckProjectRolePermissionUseCase;

class CheckProjectRolePermission implements CheckProjectRolePermissionUseCase
{
    public function hasPermission(User $user, int $projectId, ProjectPermissions $requiredPermission): bool
    {
        $hasRequiredPermission = $user->projectRolesForProject($projectId)
            ->whereHas('projectPermissions.permission.descendants', function ($query) use ($requiredPermission) {
                $query->select('id')->where('id', $requiredPermission->value);
            })
            ->exists();

        return $hasRequiredPermission;
    }
}
