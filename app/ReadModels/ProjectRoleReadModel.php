<?php

namespace App\ReadModels;

use App\ValueObjects\ProjectRoleId;
use App\ValueObjects\ProjectId;
use App\ValueObjects\ProjectRoleType;
use JsonSerializable;
use Illuminate\Support\Collection;

class ProjectRoleReadModel implements JsonSerializable
{
    /**
     * コンストラクタ
     *
     * @param ProjectRoleId $projectRoleId プロジェクトロールID
     * @param ProjectRoleType $projectRoleType プロジェクトロールタイプ
     * @param string $name ロール名
     * @param string $description ロール説明
     * @param int $assignableLimit 割り当て可能なメンバー数
     * @param int $assignedCount 割り当てられたメンバー数
     */
    public function __construct(
        public readonly ProjectRoleId $projectRoleId,
        public readonly ProjectRoleType $projectRoleType,
        public readonly string $name,
        public readonly string $description,
        public readonly int $assignableLimit,
        public readonly int $assignedCount,
    ) {}

    public function __get(string $name): mixed
    {
        return match ($name) {
            'project_role_id' => $this->projectRoleId,
            'project_role_type' => $this->projectRoleType,
            'name' => $this->name,
            'description' => $this->description,
            'assignable_limit' => $this->assignableLimit,
            'assigned_count' => $this->assignedCount,
        };
    }

    public function jsonSerialize(): array
    {
        return [
            'project_role_id' => $this->projectRoleId,
        ];
    }

}