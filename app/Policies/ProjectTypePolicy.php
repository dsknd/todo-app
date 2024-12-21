<?php

namespace App\Policies;

use App\Models\ProjectType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectTypePolicy
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
    public function view(User $user, ProjectType $projectType): bool
    {
        return false;
    }

    /**
     * Determine if the given user can create a project type.
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine if the user can update the given project type.
     */
    public function update(User $user, ProjectType $projectType)
    {
        // ロジック：例えば、作成者のみが更新できる場合
        return $user->id === $projectType->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProjectType $projectType): bool
    {
        // ロジック：例えば、作成者のみが削除できる場合
        return $user->id === $projectType->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProjectType $projectType): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProjectType $projectType): bool
    {
        return false;
    }
}
