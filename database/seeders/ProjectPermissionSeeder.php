<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\ProjectPermission;

/**
 * プロジェクトに関する権限を挿入するシーダークラス
 */
class ProjectPermissionSeeder extends Seeder
{
    /**
     * プロジェクトに関する権限を挿入する
     */
    public function run(): void
    {
        DB::transaction(function () {
            // プロジェクトに関する権限を取得
            $projectPermissions = Permission::where('resource', 'projects')->get();

            // プロジェクトタスクに関する権限を取得
            $projectTaskPermissions = Permission::where('resource', 'projects.tasks')->get();

            // プロジェクト役割に関する権限を取得
            $projectRolePermissions = Permission::where('resource', 'projects.roles')->get();

            // プロジェクトメンバーに関する権限を取得
            $projectMemberPermissions = Permission::where('resource', 'projects.members')->get();

            // プロジェクト招待に関する権限を取得
            $projectInvitationPermissions = Permission::where('resource', 'projects.invitations')->get();

            // プロジェクトに関する権限を挿入
            foreach ($projectPermissions as $permission) {
                ProjectPermission::create([
                    'permission_id' => $permission->id,
                ]);
            }

            // プロジェクトタスクに関する権限を挿入
            foreach ($projectTaskPermissions as $permission) {
                ProjectPermission::create([
                    'permission_id' => $permission->id,
                ]);
            }

            // プロジェクト役割に関する権限を挿入
            foreach ($projectRolePermissions as $permission) {
                ProjectPermission::create([
                    'permission_id' => $permission->id,
                ]);
            }

            // プロジェクトメンバーに関する権限を挿入
            foreach ($projectMemberPermissions as $permission) {
                ProjectPermission::create([
                    'permission_id' => $permission->id,
                ]);
            }

            // プロジェクト招待に関する権限を挿入
            foreach ($projectInvitationPermissions as $permission) {
                ProjectPermission::create([
                    'permission_id' => $permission->id,
                ]);
            }
        });
    }
}
