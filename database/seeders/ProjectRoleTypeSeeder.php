<?php

namespace Database\Seeders;

use App\Enums\ProjectRoleTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectRoleTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (ProjectRoleTypeEnum::cases() as $projectRoleType) {
                DB::table('project_role_types')->insert([
                    'id' => $projectRoleType->value,
                    'key' => $projectRoleType->getKey(),
                ]);
            }
        });
    }
} 