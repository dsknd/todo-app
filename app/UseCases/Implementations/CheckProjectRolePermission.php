<?php

namespace App\UseCases\Implementations;

use App\Enums\ProjectPermissionEnum;
use App\Models\User;
use App\Models\Project;
use App\UseCases\CheckProjectRolePermissionUseCase;

class CheckProjectRolePermission implements CheckProjectRolePermissionUseCase
{
    public function hasPermission(User $user, Project $project, ProjectPermissionEnum $requiredPermission): bool
    {
        $hasRequiredPermission = $user->projectRolesForProject($project->id)
            ->whereHas('projectPermissions.permission.descendants', function ($query) use ($requiredPermission) {
                $query->select('id')->where('id', $requiredPermission->value);
            })
            ->exists();

        return $hasRequiredPermission;
    }
}
