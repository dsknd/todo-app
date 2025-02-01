<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\ProjectPermission;
use App\Enums\ProjectPermissionEnum;

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
            foreach (ProjectPermissionEnum::cases() as $permission) {
                $projectPermission = new ProjectPermission();
                $projectPermission->permission_id = $permission->value;
                $projectPermission->save();
            }
        });
    }
}
