<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectRoleType;
use App\Enums\ProjectRoleTypes;

class ProjectRoleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectRoleTypes = [
            [
                'id' => ProjectRoleTypes::DEFAULT,
                'name' => 'Default',
                'description' => 'Default role'
            ],
            [
                'id' => ProjectRoleTypes::CUSTOM,
                'name' => 'Custom',
                'description' => 'Custom role'
            ],
        ];

        ProjectRoleType::insert($projectRoleTypes);
    }
}

