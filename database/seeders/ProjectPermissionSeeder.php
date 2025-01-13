<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\ProjectPermission;
use App\Enums\ProjectPermissions;

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
            // 権限IDの配列を定義
            $permissionIds = [
                ProjectPermissions::PROJECT_WILDCARD,
                ProjectPermissions::PROJECT_READ,
                ProjectPermissions::PROJECT_UPDATE,
                ProjectPermissions::PROJECT_DELETE,
                ProjectPermissions::PROJECT_TASK_WILDCARD,
                ProjectPermissions::PROJECT_TASK_READ,
                ProjectPermissions::PROJECT_TASK_CREATE,
                ProjectPermissions::PROJECT_TASK_UPDATE,
                ProjectPermissions::PROJECT_TASK_DELETE,
                ProjectPermissions::PROJECT_ROLE_WILDCARD,
                ProjectPermissions::PROJECT_ROLE_READ,
                ProjectPermissions::PROJECT_ROLE_CREATE,
                ProjectPermissions::PROJECT_ROLE_UPDATE,
                ProjectPermissions::PROJECT_ROLE_DELETE,
                ProjectPermissions::PROJECT_MEMBER_WILDCARD,
                ProjectPermissions::PROJECT_MEMBER_READ,
                ProjectPermissions::PROJECT_MEMBER_CREATE,
                ProjectPermissions::PROJECT_MEMBER_UPDATE,
                ProjectPermissions::PROJECT_MEMBER_DELETE,
                ProjectPermissions::PROJECT_INVITATION_WILDCARD,
                ProjectPermissions::PROJECT_INVITATION_READ,
                ProjectPermissions::PROJECT_INVITATION_CREATE,
                ProjectPermissions::PROJECT_INVITATION_UPDATE,
                ProjectPermissions::PROJECT_INVITATION_DELETE,
            ];

            // 各権限IDに対して個別にレコードを作成
            foreach ($permissionIds as $permissionId) {
                $projectPermission = new ProjectPermission();
                $projectPermission->permission_id = $permissionId;
                $projectPermission->save();
            }
        });
    }
}
