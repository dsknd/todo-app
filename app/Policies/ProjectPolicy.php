<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine if the given project can be viewed by the user.
     */
    public function view(User $user, Project $project)
    {
        // プロジェクトのメンバーであれば許可
        return $project->members->contains($user->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project)
    {
        // プロジェクトのオーナーまたはメンバーであれば許可
        return $user->id === $project->owner_id || $project->members->contains($user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project)
    {
        // プロジェクトのオーナーのみ許可
        return $user->id === $project->owner_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return false;
    }
}
