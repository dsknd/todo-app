<?php

namespace App\ReadModels;

use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ValueObjects\PermissionId;
use Illuminate\Support\Collection;
/**
 * プロジェクトメンバーの権限を取得するReadModel
 * 
 * @property ProjectId $projectId プロジェクトID
 * @property UserId $userId ユーザーID
 * @property array $permissionIds 権限IDの配列
 * @property array $permissionDetails 権限詳細の配列
 */
class ProjectMemberPermissionReadModel
{
    public function __construct(
        public readonly ProjectId $projectId,
        public readonly UserId $userId,
        public readonly Collection $permissions
    ) {}

    public function getPermissionIds(): array
    {
        return $this->permissionIds;
    }

    public function hasPermission(PermissionId $permissionId): bool
    {
        return in_array($permissionId->getValue(), $this->permissionIds);
    }
}