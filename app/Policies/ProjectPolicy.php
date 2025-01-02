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
     * プロジェクトを表示できるかどうかを決定します。
     *
     * プロジェクトのオーナーまたはメンバーであれば許可します。
     *
     * @param User $user
     * @param Project $project
     * @return Response
     *
     */
    public function view(User $user, Project $project): Response
    {
        $is_owner = $user->id === $project->owner_id;
        $is_member = $project->members->contains($user->id);
        if ($is_owner || $is_member) {
            return Response::allow();
        } else {
            return Response::deny('You are not a member of this project.');
        }
    }

    /**
     * Determine whether the user can create models.
     */
//    public function create(User $user): bool
//    {
//        return false;
//    }

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
