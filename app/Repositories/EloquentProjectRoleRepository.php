<?php

namespace App\Repositories;

use App\Models\ProjectRole;
use App\Repositories\Interfaces\ProjectRoleRepository;
use App\ValueObjects\ProjectRoleId;

class EloquentProjectRoleRepository implements ProjectRoleRepository
{
    /**
     * @inheritDoc
     */
    public function findById(ProjectRoleId $id): ?ProjectRole
    {
        return ProjectRole::find($id->getValue());
    }
} 