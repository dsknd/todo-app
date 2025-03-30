<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use App\UseCases\AuthorizeProjectPermissionUseCase;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectId;
use App\ValueObjects\PermissionId;
use App\Enums\PermissionEnum;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function __construct(
        private readonly AuthorizeProjectPermissionUseCase $authorizeProjectPermissionUseCase,
    ) {}

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
    public function view(User $user, Project $project): bool
    {
        return $this->authorizeProjectPermissionUseCase->execute(
            $user->id,
            $project->id,
            PermissionId::fromEnum(PermissionEnum::PROJECT_READ),
        );
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
    public function update(User $user, Project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return false;
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
