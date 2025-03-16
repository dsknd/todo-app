<?php

namespace App\UseCases;

use App\Models\ProjectRole;
use App\Models\ProjectPermission;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Project;
use App\Enums\ProjectPermissionEnum;

interface CheckProjectRolePermissionUseCase
{
    public function hasPermission(User $user, Project $project, ProjectPermissionEnum $requiredPermission): bool;
}
