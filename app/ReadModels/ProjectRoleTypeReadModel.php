<?php

namespace App\ReadModels;

use JsonSerializable;
use App\ValueObjects\ProjectRoleTypeId;

class ProjectRoleTypeReadModel implements JsonSerializable
{
    public function __construct(
        public readonly ProjectRoleTypeId $projectRoleTypeId,
        public readonly string $name,
        public readonly string $description,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->projectRoleTypeId->getValue(),
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function getProjectRoleTypeId(): ProjectRoleTypeId
    {
        return $this->projectRoleTypeId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function __get(string $name)
    {
        switch ($name) {
            case 'id':
                return $this->projectRoleTypeId->getValue();
            case 'name':
                return $this->name;
            case 'description':
                return $this->description;
        }
    }
}