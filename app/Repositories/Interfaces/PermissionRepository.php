<?php

namespace App\Repositories\Interfaces;

use App\Models\Permission;
use App\ValueObjects\PermissionId;
use Illuminate\Support\Collection;

interface PermissionRepository
{
    /**
     * IDによる権限の検索
     *
     * @param PermissionId $id
     * @return Permission|null
     */
    public function findById(PermissionId $id): ?Permission;

    /**
     * スコープによる権限の検索
     *
     * @param string $scope
     * @return Collection
     */
    public function findByScope(string $scope): Collection;

    /**
     * リソースによる権限の検索
     *
     * @param string $resource
     * @return Collection
     */
    public function findByResource(string $resource): Collection;

    /**
     * アクションによる権限の検索
     *
     * @param string $action
     * @return Collection
     */
    public function findByAction(string $action): Collection;

    /**
     * スコープ、リソース、アクションの組み合わせによる権限の検索
     *
     * @param string $scope
     * @param string $resource
     * @param string $action
     * @return Permission|null
     */
    public function findByScopeResourceAction(string $scope, string $resource, string $action): ?Permission;

    /**
     * 指定された権限の祖先権限を取得
     *
     * @param PermissionId $id
     * @return Collection
     */
    public function findAncestors(PermissionId $id): Collection;

    /**
     * 指定された権限の子孫権限を取得
     *
     * @param PermissionId $id
     * @return Collection
     */
    public function findDescendants(PermissionId $id): Collection;

    /**
     * 権限が存在するかどうかを確認
     *
     * @param PermissionId $id
     * @return bool
     */
    public function exists(PermissionId $id): bool;

    /**
     * 権限が別の権限を含むかどうかを確認
     *
     * @param PermissionId $ancestorId
     * @param PermissionId $descendantId
     * @return bool
     */
    public function contains(PermissionId $ancestorId, PermissionId $descendantId): bool;

    /**
     * 指定された権限が複数の権限のいずれかに含まれるかどうかを確認
     *
     * @param array<PermissionId> $hasPermissions
     * @param PermissionId $requiredPermissionId
     * @return bool
     */
    public function areIncludedIn(array $hasPermissions, PermissionId $requiredPermissionId): bool;

    /**
     * プロジェクト権限の判定用メソッド
     *
     * @param PermissionId $id
     * @return bool
     */
    public function isProjectPermission(PermissionId $id): bool;

    /**
     * プロジェクトで利用可能な権限の取得
     *
     * @return Collection
     */
    public function findAvailableProjectPermissions(): Collection;
} 