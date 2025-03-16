<?php

namespace App\Repositories;

use App\Models\ProjectRolePermission;
use App\Models\ProjectRole;
use App\Repositories\Interfaces\ProjectRolePermissionRepository;
use App\ValueObjects\PermissionId;
use App\ValueObjects\ProjectRoleId;
use Illuminate\Support\Collection;

class EloquentProjectRolePermissionRepository implements ProjectRolePermissionRepository
{
    /**
     * プロジェクトロールIDとプロジェクト権限IDで権限割り当てを検索
     *
     * @param ProjectRoleId $projectRoleId
     * @param PermissionId $permissionId
     * @return ProjectRolePermission|null
     */
    public function findByRoleIdAndPermissionId(
        ProjectRoleId $projectRoleId,
        PermissionId $permissionId
    ): ?ProjectRolePermission {
        return ProjectRolePermission::where('project_role_id', $projectRoleId)
            ->where('project_permission_id', $permissionId)
            ->first();
    }

    /**
     * プロジェクトロールIDに関連するすべての権限割り当てを取得
     *
     * @param ProjectRoleId $projectRoleId
     * @return Collection
     */
    public function findAllByRoleId(ProjectRoleId $projectRoleId): Collection
    {
        return ProjectRolePermission::where('project_role_id', $projectRoleId->getValue())
            ->get();
    }

    /**
     * プロジェクト権限IDに関連するすべての権限割り当てを取得
     *
     * @param PermissionId $permissionId
     * @return Collection
     */
    public function findAllByPermissionId(PermissionId $permissionId): Collection
    {
        return ProjectRolePermission::where('project_permission_id', $permissionId->getValue())
            ->get();
    }

    /**
     * 権限割り当てを作成
     *
     * @param ProjectRoleId $projectRoleId
     * @param PermissionId $permissionId
     * @return ProjectRolePermission
     */
    public function create(
        ProjectRoleId $projectRoleId,
        PermissionId $permissionId
    ): ProjectRolePermission {
        // 既に存在する場合は取得して返す
        $existing = $this->findByRoleIdAndPermissionId($projectRoleId, $permissionId);
        if ($existing) {
            return $existing;
        }

        // 新しい権限割り当てを作成
        $rolePermission = new ProjectRolePermission();
        $rolePermission->project_role_id = $projectRoleId->getValue();
        $rolePermission->project_permission_id = $permissionId->getValue();
        $rolePermission->save();

        return $rolePermission;
    }

    /**
     * 権限割り当てを削除
     *
     * @param ProjectRoleId $projectRoleId
     * @param PermissionId $permissionId
     * @return bool
     */
    public function delete(
        ProjectRoleId $projectRoleId,
        PermissionId $permissionId
    ): bool {
        return ProjectRolePermission::where('project_role_id', $projectRoleId->getValue())
            ->where('project_permission_id', $permissionId->getValue())
            ->delete() > 0;
    }

    /**
     * プロジェクトロールIDに関連するすべての権限割り当てを削除
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function deleteAllByRoleId(ProjectRoleId $projectRoleId): bool
    {
        return ProjectRolePermission::where('project_role_id', $projectRoleId->getValue())
            ->delete() > 0;
    }

    /**
     * プロジェクト権限IDに関連するすべての権限割り当てを削除
     *
     * @param PermissionId $permissionId
     * @return bool
     */
    public function deleteAllByPermissionId(PermissionId $permissionId): bool
    {
        return ProjectRolePermission::where('project_permission_id', $permissionId->getValue())
            ->delete() > 0;
    }

    /**
     * 権限割り当てが存在するかどうかを確認
     *
     * @param ProjectRoleId $projectRoleId
     * @param PermissionId $permissionId
     * @return bool
     */
    public function exists(
        ProjectRoleId $projectRoleId,
        PermissionId $permissionId
    ): bool {
        return ProjectRolePermission::where('project_role_id', $projectRoleId->getValue())
            ->where('project_permission_id', $permissionId->getValue())
            ->exists();
    }

    /**
     * プロジェクトロールに複数の権限を一括で割り当て
     *
     * @param ProjectRoleId $projectRoleId
     * @param array<PermissionId> $permissionIds
     * @return bool
     */
    public function assignPermissions(
        ProjectRoleId $projectRoleId,
        array $permissionIds
    ): bool {
        $projectRole = ProjectRole::find($projectRoleId);
        
        if (!$projectRole) {
            return false;
        }
        
        // 既存の権限を取得
        $existingPermissionIds = $projectRole->projectPermissions()
            ->pluck('project_permission_id')
            ->toArray();

        // 新しい権限のみを追加
        $newPermissionIds = array_diff($permissionIds, $existingPermissionIds);
        
        if (empty($newPermissionIds)) {
            return true; // 追加する権限がない場合は成功とみなす
        }
        
        // 権限を追加
        $attachData = [];
        foreach ($newPermissionIds as $permissionId) {
            $attachData[$permissionId->getValue()] = ['assigned_at' => now()];
        }
        
        $projectRole->projectPermissions()->attach($attachData);
        
        return true;
    }

    /**
     * プロジェクトロールから複数の権限を一括で削除
     *
     * @param ProjectRoleId $projectRoleId
     * @param array<PermissionId> $permissionIds
     * @return bool
     */
    public function removePermissions(
        ProjectRoleId $projectRoleId,
        array $permissionIds
    ): bool {
        $projectRole = ProjectRole::find($projectRoleId->getValue());
        
        if (!$projectRole) {
            return false;
        }
        
        // 権限IDの配列を整数値の配列に変換
        $permissionIds = array_map(function (PermissionId $permissionId) {
            return $permissionId->getValue();
        }, $permissionIds);
        
        // 権限を削除
        $projectRole->projectPermissions()->detach($permissionIds);
        
        return true;
    }

    /**
     * プロジェクトロールの権限をすべて置き換え
     *
     * @param ProjectRoleId $projectRoleId
     * @param array<PermissionId> $permissionIds
     * @return bool
     */
    public function syncPermissions(
        ProjectRoleId $projectRoleId,
        array $permissionIds
    ): bool {
        $projectRole = ProjectRole::find($projectRoleId->getValue());
        
        if (!$projectRole) {
            return false;
        }
        
        // 権限IDの配列を整数値の配列に変換
        $permissionIds = array_map(function (PermissionId $permissionId) {
            return $permissionId->getValue();
        }, $permissionIds);
        
        // 権限を同期（既存の権限をすべて削除し、指定された権限を追加）
        $syncData = [];
        foreach ($permissionIds as $permissionId) {
            $syncData[$permissionId] = ['assigned_at' => now()];
        }
        
        $projectRole->projectPermissions()->sync($syncData);
        
        return true;
    }
} 