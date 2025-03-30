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
 */
class ProjectMemberPermissionReadModel
{
    public function __construct(
        public readonly ProjectId $projectId,
        public readonly UserId $userId,
        public readonly Collection $permissions
    ) {}

    /**
     * 権限IDの配列を取得
     * 
     * @return array<PermissionId>
     */
    public function getPermissionIds(): array
    {
        // 権限がない場合は空の配列を返す
        if ($this->permissions->isEmpty()) {
            return [];
        }

        // 権限IDの配列を作成
        $permissionIds = [];
        foreach ($this->permissions as $permission) {
            $permissionIds[] = new PermissionId($permission->permission_id);
        }

        // 権限IDの配列を返す
        return $permissionIds;
    }
}