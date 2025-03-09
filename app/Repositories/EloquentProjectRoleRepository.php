<?php

namespace App\Repositories;

use App\Models\ProjectRole;
use App\Models\ProjectRoleType;
use App\Repositories\Interfaces\ProjectRoleRepository;
use App\ValueObjects\ProjectId;
use App\ValueObjects\ProjectRoleId;
use App\Enums\ProjectRoleTypeEnum;
use App\ValueObjects\ProjectRoleNumber;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EloquentProjectRoleRepository implements ProjectRoleRepository
{
    /**
     * @inheritDoc
     */
    public function findById(ProjectRoleId $id): ?ProjectRole
    {
        return ProjectRole::find($id->getValue());
    }

    /**
     * @inheritDoc
     */
    public function findByProjectIdAndRoleNumber(ProjectId $projectId, ProjectRoleNumber $roleNumber): ?ProjectRole
    {
        return ProjectRole::where('project_id', $projectId->getValue())
            ->where('role_number', $roleNumber)
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function findAllByProjectId(ProjectId $projectId): Collection
    {
        return ProjectRole::where('project_id', $projectId->getValue())
            ->orderBy('role_number')
            ->get();
    }

    /**
     * @inheritDoc
     */
    public function findByProjectIdPaginated(ProjectId $projectId, int $perPage = 15): LengthAwarePaginator
    {
        return ProjectRole::where('project_id', $projectId->getValue())
            ->orderBy('role_number')
            ->paginate($perPage);
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): ProjectRole
    {
        return ProjectRole::create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(ProjectRoleId $id, array $attributes): bool
    {
        $projectRole = $this->findById($id);
        
        if (!$projectRole) {
            return false;
        }
        
        return $projectRole->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function delete(ProjectRoleId $projectRoleId): bool
    {
        $projectRole = $this->findById($projectRoleId);

        if (!$projectRole) {
            return false;
        }

        return $projectRole->delete();
    }
} 