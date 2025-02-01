<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\PermissionEnum;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $permissions = $this->createPermissions();
            $closureRelations = $this->buildClosureRelations($permissions);
            DB::table('permission_closures')->insert($closureRelations);
        });
    }

    /**
     * 権限を作成
     */
    private function createPermissions(): array
    {
        $permissions = [];
        
        foreach (PermissionEnum::cases() as $permission) {
            $created = Permission::create([
                'id' => $permission->value,
                'scope' => PermissionEnum::getScope($permission->value),
                'resource' => PermissionEnum::getResource($permission->value),
                'action' => PermissionEnum::getAction($permission->value),
                'display_name' => PermissionEnum::getDisplayName($permission->value),
                'description' => PermissionEnum::getDescription($permission->value),
            ]);
            
            $permissions[$permission->value] = $created;
        }

        return $permissions;
    }

    /**
     * クロージャーテーブルの関係を作成
     */
    private function buildClosureRelations(array $permissions): array
    {
        $relations = [];
        $addedRelations = [];

        // 自己参照関係を追加
        foreach (PermissionEnum::cases() as $permission) {
            $id = $permission->value;
            if (isset($permissions[$id])) {
                $this->addRelation($relations, $addedRelations, $id, $id, 0);
            }
        }

        // 階層関係を追加
        foreach (PermissionEnum::cases() as $permission) {
            $id = $permission->value;
            if (!isset($permissions[$id])) continue;

            $hierarchy = PermissionEnum::getHierarchy($id);
            foreach ($hierarchy as $childPermission) {
                $childId = $childPermission->value;
                if (isset($permissions[$childId])) {
                    $this->addRelation(
                        $relations,
                        $addedRelations,
                        $id,
                        $childId,
                        1
                    );
                }
            }
        }

        return $relations;
    }

    /**
     * クロージャーテーブルの関係を追加
     */
    private function addRelation(array &$relations, array &$addedRelations, int $ancestorId, int $descendantId, int $depth): void
    {
        if ($ancestorId === 0 || $descendantId === 0) {
            return;
        }

        $key = "{$ancestorId}-{$descendantId}";
        if (!isset($addedRelations[$key])) {
            $relations[] = [
                'ancestor_id' => $ancestorId,
                'descendant_id' => $descendantId,
                'depth' => $depth
            ];
            $addedRelations[$key] = true;
        }
    }
}
