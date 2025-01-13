<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectRole;
use App\Models\ProjectRoleType;
use Illuminate\Support\Facades\DB;
use App\Enums\ProjectRoleTypes;
use App\Enums\ProjectPermissions;

class ProjectRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectRoles = [
            [
                'project_role_type_id' => ProjectRoleTypes::DEFAULT,
                'name' => 'Owner',
                'description' => 'This role can manage all the project functions.',
            ],
            [
                'project_role_type_id' => ProjectRoleTypes::DEFAULT,
                'name' => 'Admin',
                'description' => 'This role can manage all the project functions except for the owner.',
            ],
            [
                'project_role_type_id' => ProjectRoleTypes::DEFAULT,
                'name' => 'Member',
                'description' => 'This role can manage basic project functions.',
            ],
        ];

        DB::transaction(function () use ($projectRoles) {
            ProjectRole::insert($projectRoles);
        });
    }
}
