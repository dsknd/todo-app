<?php

namespace App\Repositories\Interfaces;

use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ReadModels\ProjectMemberPermissionReadModel;

interface ProjectMemberPermissionQueryRepository
{
    public function findMemberPermissions(ProjectId $projectId, UserId $userId): ProjectMemberPermissionReadModel;
}