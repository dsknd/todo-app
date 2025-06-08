<?php

namespace App\ReadModels;

use App\ValueObjects\ProjectRoleId;
use App\ValueObjects\ProjectId;
use App\Models\ProjectRoleType;
use JsonSerializable;

class ProjectRoleReadModel implements JsonSerializable
{
    public function __construct(
        public readonly ProjectRoleId $projectRoleId,
        public readonly ProjectId $projectId,
        public readonly ProjectRoleType $projectRoleType,
        public readonly string $name,
        public readonly string $description,
        public readonly int $assignableLimit,
        public readonly int $assignedCount,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'project_role_id' => $this->projectRoleId,
        ];
    }

}