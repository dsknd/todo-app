<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Permissions;
class PermissionSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            // 1. 全ての権限を作成
            $permissions = $this->createPermissions();

            // 2. 権限階層の定義
            $hierarchyDefinitions = $this->defineHierarchy();

            // 3. 閉包テーブルのデータを生成
            $closureRelations = $this->buildClosureRelations($permissions, $hierarchyDefinitions);

            // 4. 閉包テーブルにデータを挿入
            DB::table('permission_closures')->insert($closureRelations);
        });
    }

    private function createPermissions(): array
    {
        $permissionDefinitions = [
            [
                'id' => Permissions::PROJECT_WILDCARD,
                'scope' => 'projects:*',
                'resource' => 'projects',
                'action' => '*',
                'display_name' => 'プロジェクト全ての権限',
                'description' => 'プロジェクトの全ての権限が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_READ,
                'scope' => 'projects:read',
                'resource' => 'projects',
                'action' => 'read',
                'display_name' => 'プロジェクト読み取り権限',
                'description' => 'プロジェクトの読み取りが可能です。',
            ],
            [
                'id' => Permissions::PROJECT_UPDATE,
                'scope' => 'projects:update',
                'resource' => 'projects',
                'action' => 'update',
                'display_name' => 'プロジェクト更新権限',
                'description' => 'プロジェクトの更新が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_DELETE,
                'scope' => 'projects:delete',
                'resource' => 'projects',
                'action' => 'delete',
                'display_name' => 'プロジェクト削除権限',
                'description' => 'プロジェクトの削除が可能です。',
            ],

            [
                'id' => Permissions::PROJECT_TASKS_WILDCARD,
                'scope' => 'projects:tasks:*',
                'resource' => 'projects.tasks',
                'action' => '*',
                'display_name' => 'プロジェクトタスク全ての権限',
                'description' => 'プロジェクトタスクの全ての権限が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_TASKS_READ,
                'scope' => 'projects:tasks:read',
                'resource' => 'projects.tasks',
                'action' => 'read',
                'display_name' => 'プロジェクトタスク読み取り権限',
                'description' => 'プロジェクトタスクに関する読み取り操作が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_TASKS_CREATE,
                'scope' => 'projects:tasks:create',
                'resource' => 'projects.tasks',
                'action' => 'create',
                'display_name' => 'プロジェクトタスク作成権限',
                'description' => 'プロジェクトタスクの作成が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_TASKS_UPDATE,
                'scope' => 'projects:tasks:update',
                'resource' => 'projects.tasks',
                'action' => 'update',
                'display_name' => 'プロジェクトタスク更新権限',
                'description' => 'プロジェクトタスクの更新が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_TASKS_DELETE,
                'scope' => 'projects:tasks:delete',
                'resource' => 'projects.tasks',
                'action' => 'delete',
                'display_name' => 'プロジェクトタスク削除権限',
                'description' => 'プロジェクトタスクの削除が可能です。',
            ],

            [
                'id' => Permissions::PROJECT_ROLES_WILDCARD,
                'scope' => 'projects:roles:*',
                'resource' => 'projects.roles',
                'action' => '*',
                'display_name' => 'プロジェクト役割全ての権限',
                'description' => 'プロジェクト役割の全ての権限が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_ROLES_READ,
                'scope' => 'projects:roles:read',
                'resource' => 'projects.roles',
                'action' => 'read',
                'display_name' => 'プロジェクト役割読み取り権限',
                'description' => 'プロジェクト役割に関する読み取り操作が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_ROLES_CREATE,
                'scope' => 'projects:roles:create',
                'resource' => 'projects.roles',
                'action' => 'create',
                'display_name' => 'プロジェクト役割作成権限',
                'description' => 'プロジェクト役割の作成が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_ROLES_UPDATE,
                'scope' => 'projects:roles:update',
                'resource' => 'projects.roles',
                'action' => 'update',
                'display_name' => 'プロジェクト役割更新権限',
                'description' => 'プロジェクト役割の更新が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_ROLES_DELETE,
                'scope' => 'projects:roles:delete',
                'resource' => 'projects.roles',
                'action' => 'delete',
                'display_name' => 'プロジェクト役割削除権限',
                'description' => 'プロジェクト役割の削除が可能です。',
            ],

            [
                'id' => Permissions::PROJECT_MEMBERS_WILDCARD,
                'scope' => 'projects:members:*',
                'resource' => 'projects.members',
                'action' => '*',
                'display_name' => 'プロジェクトメンバー全ての権限',
                'description' => 'プロジェクトメンバーの全ての権限が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_MEMBERS_READ,
                'scope' => 'projects:members:read',
                'resource' => 'projects.members',
                'action' => 'read',
                'display_name' => 'プロジェクトメンバー読み取り権限',
                'description' => 'プロジェクトメンバーに関する読み取り操作が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_MEMBERS_CREATE,
                'scope' => 'projects:members:create',
                'resource' => 'projects.members',
                'action' => 'create',
                'display_name' => 'プロジェクトメンバー作成権限',
                'description' => 'プロジェクトメンバーの作成が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_MEMBERS_UPDATE,
                'scope' => 'projects:members:update',
                'resource' => 'projects.members',
                'action' => 'update',
                'display_name' => 'プロジェクトメンバー更新権限',
                'description' => 'プロジェクトメンバーの更新が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_MEMBERS_DELETE,
                'scope' => 'projects:members:delete',
                'resource' => 'projects.members',
                'action' => 'delete',
                'display_name' => 'プロジェクトメンバー削除権限',
                'description' => 'プロジェクトメンバーの削除が可能です。',
            ],

            [
                'id' => Permissions::PROJECT_INVITATIONS_WILDCARD,
                'scope' => 'projects:invitations:*',
                'resource' => 'projects.invitations',
                'action' => '*',
                'display_name' => 'プロジェクト招待全ての権限',
                'description' => 'プロジェクト招待の全ての権限が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_INVITATIONS_READ,
                'scope' => 'projects:invitations:read',
                'resource' => 'projects.invitations',
                'action' => 'read',
                'display_name' => 'プロジェクト招待読み取り権限',
                'description' => 'プロジェクト招待に関する読み取り操作が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_INVITATIONS_CREATE,
                'scope' => 'projects:invitations:create',
                'resource' => 'projects.invitations',
                'action' => 'create',
                'display_name' => 'プロジェクト招待作成権限',
                'description' => 'プロジェクト招待の作成が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_INVITATIONS_UPDATE,
                'scope' => 'projects:invitations:update',
                'resource' => 'projects.invitations',
                'action' => 'update',
                'display_name' => 'プロジェクト招待更新権限',
                'description' => 'プロジェクト招待の更新が可能です。',
            ],
            [
                'id' => Permissions::PROJECT_INVITATIONS_DELETE,
                'scope' => 'projects:invitations:delete',
                'resource' => 'projects.invitations',
                'action' => 'delete',
                'display_name' => 'プロジェクト招待削除権限',
                'description' => 'プロジェクト招待の削除が可能です。',
            ],
        ];

        $permissions = [];
        foreach ($permissionDefinitions as $definition) {
            $permissions[$definition['scope']] = Permission::create($definition);
        }

        return $permissions;
    }

    private function defineHierarchy(): array
    {
        return [
            'projects:*' => [
                'projects:read',
                'projects:update',
                'projects:delete',
            ],
            'projects:tasks:*' => [
                'projects:tasks:read',
                'projects:tasks:create',
                'projects:tasks:update',
                'projects:tasks:delete',
            ],
            'projects:roles:*' => [
                'projects:roles:read',
                'projects:roles:create',
                'projects:roles:update',
                'projects:roles:delete',
            ],
            'projects:members:*' => [
                'projects:members:read',
                'projects:members:create',
                'projects:members:update',
                'projects:members:delete',
            ],
            'projects:invitations:*' => [
                'projects:invitations:read',
                'projects:invitations:create',
                'projects:invitations:update',
                'projects:invitations:delete',
            ],
        ];
    }

    private function buildClosureRelations(array $permissions, array $hierarchy): array
    {
        $relations = [];
        $addedRelations = []; // 重複チェック用の配列

        // ヘルパー関数：重複チェックと追加
        $addRelation = function ($ancestor_id, $descendant_id, $depth) use (&$relations, &$addedRelations) {
            $key = $ancestor_id . '-' . $descendant_id;
            // 既存の関係がある場合は、より短いパスを優先
            if (isset($addedRelations[$key])) {
                foreach ($relations as &$relation) {
                    if (
                        $relation['ancestor_id'] === $ancestor_id &&
                        $relation['descendant_id'] === $descendant_id &&
                        $relation['depth'] > $depth
                    ) {
                        $relation['depth'] = $depth;
                    }
                }
            } else {
                $relations[] = [
                    'ancestor_id' => $ancestor_id,
                    'descendant_id' => $descendant_id,
                    'depth' => $depth
                ];
                $addedRelations[$key] = true;
            }
        };

        // 1. 自己参照関係を追加（depth = 0）
        foreach ($permissions as $permission) {
            $addRelation($permission->id, $permission->id, 0);
        }

        // 2. 直接の親子関係を処理（depth = 1）
        foreach ($hierarchy as $parentScope => $childrenScopes) {
            if (!isset($permissions[$parentScope])) {
                continue;
            }

            foreach ($childrenScopes as $childScope) {
                if (!isset($permissions[$childScope])) {
                    continue;
                }

                $addRelation($permissions[$parentScope]->id, $permissions[$childScope]->id, 1);
            }
        }

        // 3. 間接的な関係を処理（閉包性を確保）
        $changed = true;
        while ($changed) {
            $changed = false;
            $existingRelations = $relations;

            foreach ($existingRelations as $r1) {
                foreach ($existingRelations as $r2) {
                    if ($r1['descendant_id'] === $r2['ancestor_id']) {
                        $newDepth = $r1['depth'] + $r2['depth'];
                        $key = $r1['ancestor_id'] . '-' . $r2['descendant_id'];

                        if (
                            !isset($addedRelations[$key]) ||
                            $newDepth < $relations[array_search($key, array_map(function ($r) {
                                return $r['ancestor_id'] . '-' . $r['descendant_id'];
                            }, $relations))]['depth']
                        ) {
                            $addRelation($r1['ancestor_id'], $r2['descendant_id'], $newDepth);
                            $changed = true;
                        }
                    }
                }
            }
        }

        return $relations;
    }
}
