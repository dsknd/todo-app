<?php

namespace App\UseCases;

use App\Models\ProjectRole;
use App\Models\ProjectPermission;
use Illuminate\Support\Facades\Cache;

class CheckProjectRolePermissionUseCase
{
    /**
     * プロジェクトロールが指定された権限を持っているかチェック
     *
     * @param ProjectRole $role チェック対象のプロジェクトロール
     * @param string $permissionName チェックする権限名
     * @return bool 権限を持っている場合はtrue
     */
    public function execute(ProjectRole $role, string $permissionName): bool
    {
        // キャッシュキーを生成
        $cacheKey = "role_permission:{$role->id}:{$permissionName}";

        // キャッシュから結果を取得、なければ計算して保存
        return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($role, $permissionName) {
            // 権限を取得
            $permission = ProjectPermission::where('name', $permissionName)->first();
            if (!$permission) {
                return false;
            }

            // ロールに直接割り当てられた権限をチェック
            $hasDirectPermission = $role->projectPermissions()
                ->where('project_permissions.id', $permission->id)
                ->exists();

            if ($hasDirectPermission) {
                return true;
            }

            // 親権限をチェック
            $ancestorIds = $permission->permission->ancestors()
                ->pluck('ancestor_id')
                ->toArray();

            return $role->projectPermissions()
                ->whereIn('permission_id', $ancestorIds)
                ->exists();
        });
    }

    /**
     * プロジェクトロールの権限キャッシュをクリア
     *
     * @param ProjectRole $role キャッシュをクリアするロール
     */
    public function clearCache(ProjectRole $role): void
    {
        $permissions = ProjectPermission::all();
        foreach ($permissions as $permission) {
            Cache::forget("role_permission:{$role->id}:{$permission->name}");
        }
    }

    /**
     * 複数の権限をまとめてチェック
     *
     * @param ProjectRole $role チェック対象のプロジェクトロール
     * @param array<string> $permissionNames チェックする権限名の配列
     * @return array<string, bool> 権限名をキー、チェック結果を値とする配列
     */
    public function executeMultiple(ProjectRole $role, array $permissionNames): array
    {
        $results = [];
        foreach ($permissionNames as $permissionName) {
            $results[$permissionName] = $this->execute($role, $permissionName);
        }
        return $results;
    }

    /**
     * プロジェクトロールが持つ全権限を取得
     *
     * @param ProjectRole $role 対象のプロジェクトロール
     * @return array<string> 権限名の配列
     */
    public function getAllPermissions(ProjectRole $role): array
    {
        // キャッシュキーを生成
        $cacheKey = "role_all_permissions:{$role->id}";

        // キャッシュから結果を取得、なければ計算して保存
        return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($role) {
            // 直接割り当てられた権限を取得
            $directPermissions = $role->projectPermissions()
                ->pluck('name')
                ->toArray();

            // 親権限から継承された権限を取得
            $inheritedPermissions = $role->projectPermissions()
                ->with('permission.ancestors')
                ->get()
                ->flatMap(function ($permission) {
                    return $permission->permission->ancestors
                        ->pluck('name')
                        ->toArray();
                })
                ->unique()
                ->values()
                ->toArray();

            return array_unique(array_merge($directPermissions, $inheritedPermissions));
        });
    }
}
