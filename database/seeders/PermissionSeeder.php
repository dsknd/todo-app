<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run():void
    {
        // 権限データ
        $permissions = [
            // Project permissions
            [
                'resource' => 'projects',
                'action' => 'read',
                'name' => 'View Projects',
                'description' => 'Permission to view projects',
                'parent_id' => null,
            ],
            [
                'resource' => 'projects',
                'action' => 'write',
                'name' => 'Edit Projects',
                'description' => 'Permission to edit projects',
                'parent_id' => null, // 後で設定
            ],
            [
                'resource' => 'projects',
                'action' => 'delete',
                'name' => 'Delete Projects',
                'description' => 'Permission to delete projects',
                'parent_id' => null, // 後で設定
            ],

            // Project invitation permissions
            [
                'resource' => 'project_invitations',
                'action' => 'invite',
                'name' => 'Invite Members',
                'description' => 'Permission to invite members to the project',
                'parent_id' => null,
            ],
            [
                'resource' => 'project_invitations',
                'action' => 'approve',
                'name' => 'Approve Invitations',
                'description' => 'Permission to approve project invitations',
                'parent_id' => null, // 後で設定
            ],
            [
                'resource' => 'project_invitations',
                'action' => 'revoke',
                'name' => 'Revoke Invitations',
                'description' => 'Permission to revoke project invitations',
                'parent_id' => null, // 後で設定
            ],
        ];

        // 権限の作成
        $createdPermissions = [];
        foreach ($permissions as $permission) {
            $createdPermissions[] = Permission::create($permission);
        }

        // 包含関係の設定
        foreach ($createdPermissions as $permission) {
            if ($permission->action === 'write') {
                $parent = Permission::where('resource', $permission->resource)
                    ->where('action', 'read')
                    ->first();
                $permission->parent_id = $parent->id;
                $permission->save();
            } elseif ($permission->action === 'create') {
                $parent = Permission::where('resource', $permission->resource)
                    ->where('action', 'write')
                    ->first();
                $permission->parent_id = $parent->id;
                $permission->save();
            } elseif ($permission->action === 'delete') {
                $parent = Permission::where('resource', $permission->resource)
                    ->where('action', 'write')
                    ->first();
                $permission->parent_id = $parent->id;
                $permission->save();
            } elseif ($permission->action === 'approve' || $permission->action === 'revoke') {
                $parent = Permission::where('resource', $permission->resource)
                    ->where('action', 'invite')
                    ->first();
                $permission->parent_id = $parent->id;
                $permission->save();
            }
        }
    }
}
