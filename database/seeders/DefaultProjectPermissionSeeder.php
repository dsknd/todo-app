<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\DefaultProjectRolePermissonEnum;
use App\Enums\DefaultProjectRoleEnum;

class DefaultProjectPermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (DefaultProjectRoleEnum::cases() as $role) {
                $permissions = DefaultProjectRolePermissonEnum::getPermissions($role);
                foreach ($permissions as $permission) {
                    DB::table('project_role_permissions')->insert([
                        'project_role_id' => $role->value,
                        'project_permission_id' => $permission->value,
                    ]);
                }
            }
        });
    }
}