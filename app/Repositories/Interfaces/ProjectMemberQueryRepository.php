<?php

namespace App\Repositories\Interfaces;

use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ReadModels\ProjectMemberPermissionReadModel;

interface ProjectMemberQueryRepository
{
    public function findMemberPermissions(ProjectId $projectId, UserId $userId): ProjectMemberPermissionReadModel;
}