<?php

namespace App\Policies;

use App\Models\ProjectRole;
use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\Response;
use App\Enums\ProjectPermissions;
use Illuminate\Support\Facades\Log;
use App\Models\Permission;

class ProjectRolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProjectRole $projectRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Project $project): bool
    {
        $requiredPermissionId = ProjectPermissions::PROJECT_ROLE_CREATE;

        $permissions = $user->projectRolesForProject($project->id)
            ->with([
                'projectPermissions.permission.descendants' => function ($query) {
                    $query->select('id', 'scope', 'ancestor_id', 'descendant_id'); // 必要なフィールドを指定
                }
            ])
            ->select('id') // 必要に応じて親のフィールドを絞り込む
            ->get();

        // 子孫の scope のみを抽出
        $permissionIds = $permissions->flatMap(function ($role) {
            return $role->projectPermissions->flatMap(function ($projectPermission) {
                return $projectPermission->permission->descendants->pluck('id');
            });
        });

        Log::info('permissionIds: ' . $permissionIds);

        // 必要な権限が含まれているか確認
        if ($permissionIds->contains($requiredPermissionId)) {
            Log::info("The required permission '{$requiredPermissionId}' is granted.");
            return true;
        } else {
            Log::warning("The required permission '{$requiredPermissionId}' is missing.");
            return false;
        }
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProjectRole $projectRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectRole $projectRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectRole $projectRole): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectRole $projectRole): bool
    {
        return false;
    }
}
