<?php

namespace App\ValueObjects;

use JsonSerializable;

class ProjectRoleType implements JsonSerializable
{
    public function __construct(
        public readonly ProjectRoleTypeId $id,
        public readonly string $name,
        public readonly string $description,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    public function getId(): ProjectRoleTypeId
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

    public static function from(ProjectRoleTypeId $id, string $name, string $description): self
    {
        return new self($id, $name, $description);
    }
}