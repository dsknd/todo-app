<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\PermissionClosure;
use App\Models\ProjectPermission;
use App\Repositories\Interfaces\PermissionRepository;
use App\ValueObjects\PermissionId;
use Illuminate\Support\Collection;

class EloquentPermissionRepository implements PermissionRepository
{
    /**
     * IDによる権限の検索
     *
     * @param PermissionId $id
     * @return Permission|null
     */
    public function findById(PermissionId $id): ?Permission
    {
        return Permission::find($id->getValue());
    }

    /**
     * スコープによる権限の検索
     *
     * @param string $scope
     * @return Collection
     */
    public function findByScope(string $scope): Collection
    {
        return Permission::where('scope', $scope)->get();
    }

    /**
     * リソースによる権限の検索
     *
     * @param string $resource
     * @return Collection
     */
    public function findByResource(string $resource): Collection
    {
        return Permission::where('resource', $resource)->get();
    }

    /**
     * アクションによる権限の検索
     *
     * @param string $action
     * @return Collection
     */
    public function findByAction(string $action): Collection
    {
        return Permission::where('action', $action)->get();
    }

    /**
     * スコープ、リソース、アクションの組み合わせによる権限の検索
     *
     * @param string $scope
     * @param string $resource
     * @param string $action
     * @return Permission|null
     */
    public function findByScopeResourceAction(string $scope, string $resource, string $action): ?Permission
    {
        return Permission::where('scope', $scope)
            ->where('resource', $resource)
            ->where('action', $action)
            ->first();
    }

    /**
     * 指定された権限の祖先権限を取得
     *
     * @param PermissionId $permissionId
     * @return Collection
     */
    public function findAncestors(PermissionId $permissionId): Collection
    {
        $permission = $this->findById($permissionId);
        
        if (!$permission) {
            return collect();
        }
        
        return $permission->ancestors()
            ->wherePivot('depth', '>', 0)
            ->get();
    }

    /**
     * 指定された権限の子孫権限を取得
     *
     * @param PermissionId $id
     * @return Collection
     */
    public function findDescendants(PermissionId $id): Collection
    {
        $permission = $this->findById($id);
        
        if (!$permission) {
            return collect();
        }
        
        return $permission->descendants()
            ->wherePivot('depth', '>', 0)
            ->get();
    }

    /**
     * 権限が存在するかどうかを確認
     *
     * @param PermissionId $id
     * @return bool
     */
    public function exists(PermissionId $id): bool
    {
        return Permission::where('id', $id->getValue())->exists();
    }

    /**
     * 権限が別の権限を含むかどうかを確認
     *
     * @param PermissionId $ancestorId
     * @param PermissionId $descendantId
     * @return bool
     */
    public function contains(PermissionId $ancestorId, PermissionId $descendantId): bool
    {
        $ancestor = $this->findById($ancestorId);
        $descendant = $this->findById($descendantId);
        
        if (!$ancestor || !$descendant) {
            return false;
        }
        
        return $ancestor->contains($descendant);
    }

    /**
     * inherit doc
     */
    public function areIncludedIn(array $hasPermissions, PermissionId $requiredPermissionId): bool
    {
        return $this->findById($requiredPermissionId)
            ->ancestors()
            ->whereIn('permissions.id', $hasPermissions)
            ->exists();
    }

    /**
     * inherit doc
     */
    public function imply(array $hasPermissions, PermissionId $requiredPermissionId): bool
    {
        return $this->findById($requiredPermissionId)
            ->ancestors()
            ->whereIn('permissions.id', $hasPermissions)
            ->exists();
    }

    public function isProjectPermission(PermissionId $id): bool
    {
        return ProjectPermission::where('permission_id', $id->getValue())->exists();
    }

    public function findAvailableProjectPermissions(): Collection
    {
        // まずproject_permissionsテーブルから許可された権限のIDを取得
        $permissions = ProjectPermission::query()
            ->join('permissions', 'project_permissions.permission_id', '=', 'permissions.id')
            ->get();

        return $permissions;
    }
} 