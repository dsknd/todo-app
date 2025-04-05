<?php

namespace Tests\Helpers;

use App\Models\Project;
use App\Enums\PermissionEnum;
use App\Enums\ProjectPermissionEnum;
use App\Models\Permission;
use App\Models\ProjectPermission;
use App\ValueObjects\PermissionId;

class PermissionSetup
{
    public static function setupProjectPermission(Project $project): void
    {
        foreach (PermissionEnum::cases() as $permission) {
            Permission::factory()->create([
                'id' => PermissionId::fromEnum($permission),
                'scope' => Permission::getScope($permission),
                'resource' => Permission::getResource($permission),
                'action' => Permission::getAction($permission),
            ]);
        }

        foreach (ProjectPermissionEnum::cases() as $projectPermission) {
            ProjectPermission::factory()->create([
                'id' => new PermissionId($projectPermission->value),
            ]);
        }

         
    }
}
