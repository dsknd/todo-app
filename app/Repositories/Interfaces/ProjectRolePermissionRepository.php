<?php

namespace App\Repositories\Interfaces;

use App\Models\ProjectRolePermission;
use App\ValueObjects\PermissionId;
use App\ValueObjects\ProjectRoleId;
use Illuminate\Support\Collection;

interface ProjectRolePermissionRepository
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
    ): ?ProjectRolePermission;

    /**
     * プロジェクトロールIDに関連するすべての権限割り当てを取得
     *
     * @param ProjectRoleId $projectRoleId
     * @return Collection
     */
    public function findAllByRoleId(ProjectRoleId $projectRoleId): Collection;

    /**
     * プロジェクト権限IDに関連するすべての権限割り当てを取得
     *
     * @param PermissionId $permissionId
     * @return Collection
     */
    public function findAllByPermissionId(PermissionId $permissionId): Collection;

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
    ): ProjectRolePermission;

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
    ): bool;

    /**
     * プロジェクトロールIDに関連するすべての権限割り当てを削除
     *
     * @param ProjectRoleId $projectRoleId
     * @return bool
     */
    public function deleteAllByRoleId(ProjectRoleId $projectRoleId): bool;

    /**
     * プロジェクト権限IDに関連するすべての権限割り当てを削除
     *
     * @param ProjectPermissionId $projectPermissionId
     * @return bool
     */
    public function deleteAllByPermissionId(PermissionId $permissionId): bool;

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
    ): bool;

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
    ): bool;

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
    ): bool;
} 