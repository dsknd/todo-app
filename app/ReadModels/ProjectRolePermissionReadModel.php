<?php

namespace App\ReadModels;

use App\ValueObjects\ProjectPermissionId;
use JsonSerializable;

class ProjectRolePermissionReadModel implements JsonSerializable
{
    public function __construct(
        public readonly ProjectPermissionId $id,
        public readonly string $name,
        public readonly string $description,
        public readonly string $scope,
        public readonly string $resource,
        public readonly string $action,
    ) {}

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'scope' => $this->scope,
            'resource' => $this->resource,
            'action' => $this->action,
        ];
    }

    public function getId(): ProjectPermissionId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function getResource(): string
    {
        return $this->resource;
    }

    public function getAction(): string
    {
        return $this->action;
    }
}