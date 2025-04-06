<?php

namespace Database\Seeders;

use App\Enums\DefaultProjectRoleEnum;
use App\Enums\ProjectRoleTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultProjectRoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (DefaultProjectRoleEnum::cases() as $role) {
                $projectRoleId = DB::table('project_roles')->insertGetId([
                    'id' => $role->value,
                    'project_role_type_id' => ProjectRoleTypeEnum::DEFAULT->value,
                    'assignable_limit' => DefaultProjectRoleEnum::getAssignableLimit($role),
                    'assigned_count' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('default_project_roles')->insert([
                    'project_role_id' => $projectRoleId,
                    'key' => DefaultProjectRoleEnum::getKey($role),
                ]);
            }
        });
    }
}
