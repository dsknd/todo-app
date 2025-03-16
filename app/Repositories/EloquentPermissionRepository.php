<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Repositories\Interfaces\PermissionRepository;
use App\ValueObjects\PermissionId;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
     * @param PermissionId $id
     * @return Collection
     */
    public function findAncestors(PermissionId $id): Collection
    {
        $permission = $this->findById($id);
        
        if (!$permission) {
            return collect();
        }
        
        return $permission->ancestors()->get();
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
        
        return $permission->descendants()->get();
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
} 