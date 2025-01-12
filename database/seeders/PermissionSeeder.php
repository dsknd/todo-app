<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            ['scope' => 'projects:admin',
             'resource' => 'projects',
             'action' => 'admin',
             'display_name' => 'プロジェクト管理者',
             'description' => 'プロジェクトに関するすべての操作が可能です。',
            ],
            ['scope' => 'projects:write',
             'resource' => 'projects',
             'action' => 'write',
             'display_name' => 'プロジェクト書き込み権限',
             'description' => 'プロジェクト、プロジェクトタスク、プロジェクトロール、プロジェクトメンバー、プロジェクト招待に関する書き込みが可能です。',
            ],
            ['scope' => 'projects:read',
             'resource' => 'projects',
             'action' => 'read',
             'display_name' => 'プロジェクト読み取り権限',
             'description' => 'プロジェクト、プロジェクトタスク、プロジェクトロール、プロジェクトメンバー、プロジェクト招待に関する読み取りが可能です。',
            ],
            ['scope' => 'projects:update',
             'resource' => 'projects',
             'action' => 'update',
             'display_name' => 'プロジェクト更新権限',
             'description' => 'プロジェクトの更新が可能です。',
            ],
            ['scope' => 'projects:delete',
             'resource' => 'projects',
             'action' => 'delete',
             'display_name' => 'プロジェクト削除権限',
             'description' => 'プロジェクトの削除が可能です。',
            ],
            
            ['scope' => 'projects:tasks:write',
             'resource' => 'projects.tasks',
             'action' => 'write',
             'display_name' => 'プロジェクトタスク書き込み権限',
             'description' => 'プロジェクトタスクに関する書き込み操作が可能です。',
            ],
            ['scope' => 'projects:tasks:read',
             'resource' => 'projects.tasks',
             'action' => 'read',
             'display_name' => 'プロジェクトタスク読み取り権限',
             'description' => 'プロジェクトタスクに関する読み取り操作が可能です。',
            ],
            ['scope' => 'projects:tasks:create',
             'resource' => 'projects.tasks',
             'action' => 'create',
             'display_name' => 'プロジェクトタスク作成権限',
             'description' => 'プロジェクトタスクの作成が可能です。',
            ],
            ['scope' => 'projects:tasks:update',
             'resource' => 'projects.tasks',
             'action' => 'update',
             'display_name' => 'プロジェクトタスク更新権限',
             'description' => 'プロジェクトタスクの更新が可能です。',
            ],
            ['scope' => 'projects:tasks:delete',
             'resource' => 'projects.tasks',
             'action' => 'delete',
             'display_name' => 'プロジェクトタスク削除権限',
             'description' => 'プロジェクトタスクの削除が可能です。',
            ],
            
            ['scope' => 'projects:roles:write',
             'resource' => 'projects.roles',
             'action' => 'write',
             'display_name' => 'プロジェクト役割書き込み権限',
             'description' => 'プロジェクト役割に関する書き込み操作が可能です。',
            ],
            ['scope' => 'projects:roles:read',
             'resource' => 'projects.roles',
             'action' => 'read',
             'display_name' => 'プロジェクト役割読み取り権限',
             'description' => 'プロジェクト役割に関する読み取り操作が可能です。',
            ],
            ['scope' => 'projects:roles:create',
             'resource' => 'projects.roles',
             'action' => 'create',
             'display_name' => 'プロジェクト役割作成権限',
             'description' => 'プロジェクト役割の作成が可能です。',
            ],
            ['scope' => 'projects:roles:update',
             'resource' => 'projects.roles',
             'action' => 'update',
             'display_name' => 'プロジェクト役割更新権限',
             'description' => 'プロジェクト役割の更新が可能です。',
            ],
            ['scope' => 'projects:roles:delete',
             'resource' => 'projects.roles',
             'action' => 'delete',
             'display_name' => 'プロジェクト役割削除権限',
             'description' => 'プロジェクト役割の削除が可能です。',
            ],
            
            ['scope' => 'projects:members:write',
             'resource' => 'projects.members',
             'action' => 'write',
             'display_name' => 'プロジェクトメンバー基本権限',
             'description' => 'プロジェクトメンバーに関する基本操作が可能です。',
            ],
            ['scope' => 'projects:members:read',
             'resource' => 'projects.members',
             'action' => 'read',
             'display_name' => 'プロジェクトメンバー読み取り権限',
             'description' => 'プロジェクトメンバーに関する読み取り操作が可能です。',
            ],
            ['scope' => 'projects:members:create',
             'resource' => 'projects.members',
             'action' => 'create',
             'display_name' => 'プロジェクトメンバー作成権限',
             'description' => 'プロジェクトメンバーの作成が可能です。',
            ],
            ['scope' => 'projects:members:update',
             'resource' => 'projects.members',
             'action' => 'update',
             'display_name' => 'プロジェクトメンバー更新権限',
             'description' => 'プロジェクトメンバーの更新が可能です。',
            ],
            ['scope' => 'projects:members:delete',
             'resource' => 'projects.members',
             'action' => 'delete',
             'display_name' => 'プロジェクトメンバー削除権限',
             'description' => 'プロジェクトメンバーの削除が可能です。',
            ],
            
            ['scope' => 'projects:invitations:write',
             'resource' => 'projects.invitations',
             'action' => 'write',
             'display_name' => 'プロジェクト招待書き込み権限',
             'description' => 'プロジェクト招待に関する書き込み操作が可能です。',
            ],
            ['scope' => 'projects:invitations:read',
             'resource' => 'projects.invitations',
             'action' => 'read',
             'display_name' => 'プロジェクト招待読み取り権限',
             'description' => 'プロジェクト招待に関する読み取り操作が可能です。',
            ],
            ['scope' => 'projects:invitations:create',
             'resource' => 'projects.invitations',
             'action' => 'create',
             'display_name' => 'プロジェクト招待作成権限',
             'description' => 'プロジェクト招待の作成が可能です。',
            ],
            ['scope' => 'projects:invitations:update',
             'resource' => 'projects.invitations',
             'action' => 'update',
             'display_name' => 'プロジェクト招待更新権限',
             'description' => 'プロジェクト招待の更新が可能です。',
            ],
            ['scope' => 'projects:invitations:delete',
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
            'projects:admin' => [
                'projects:write',
                'projects:read',
                'projects:tasks:read',
                'projects:roles:read',
                'projects:members:read',
                'projects:invitations:read',
                'projects:tasks:write',
                'projects:tasks:create',
                'projects:tasks:update',
                'projects:tasks:delete',
                'projects:roles:write',
                'projects:roles:create',
                'projects:roles:update',
                'projects:roles:delete',
                'projects:members:write',
                'projects:members:create',
                'projects:members:update',
                'projects:members:delete',
                'projects:invitations:write',
                'projects:invitations:create',
                'projects:invitations:update',
                'projects:invitations:delete',
                'projects:update',
                'projects:delete',
            ],
            'project:write' => [
                'projects:read',
                'projects:tasks:read',
                'projects:roles:read',
                'projects:members:read',
                'projects:invitations:read',
                'projects:tasks:write',
                'projects:tasks:create',
                'projects:tasks:update',
                'projects:tasks:delete',
                'projects:roles:write',
                'projects:roles:create',
                'projects:roles:update',
                'projects:roles:delete',
                'projects:members:write',
                'projects:members:create',
                'projects:members:update',
                'projects:members:delete',
                'projects:invitations:write',
                'projects:invitations:create',
                'projects:invitations:update',
                'projects:invitations:delete',
                'projects:update',
                'projects:delete',
            ],
            'project:read' => [
                'projects:tasks:read',
                'projects:roles:read',
                'projects:members:read',
                'projects:invitations:read',
            ],
            'project:task:write' => [
                'projects:tasks:read',
                'projects:tasks:create',
                'projects:tasks:update',
                'projects:tasks:delete',
            ],
            'project:role:write' => [
                'projects:roles:read',
                'projects:roles:create',
                'projects:roles:update',
                'projects:roles:delete',
            ],
            'project:member:write' => [
                'projects:members:read',
                'projects:members:create',
                'projects:members:update',
                'projects:members:delete',
            ],
            'project:invitation:write' => [
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
        $addRelation = function($ancestor_id, $descendant_id, $depth) use (&$relations, &$addedRelations) {
            $key = $ancestor_id . '-' . $descendant_id;
            // 既存の関係がある場合は、より短いパスを優先
            if (isset($addedRelations[$key])) {
                foreach ($relations as &$relation) {
                    if ($relation['ancestor_id'] === $ancestor_id && 
                        $relation['descendant_id'] === $descendant_id && 
                        $relation['depth'] > $depth) {
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
                        
                        if (!isset($addedRelations[$key]) || 
                            $newDepth < $relations[array_search($key, array_map(function($r) {
                                return $r['ancestor_id'] . '-' . $r['descendant_id'];
                            }, $relations))]['depth']) {
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
