<?php

namespace Database\Seeders;

use App\Enums\ProjectRoleTypeEnum;
use App\Enums\LocaleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ProjectRoleTypeTranslationEnum;

class ProjectRoleTypeTranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (ProjectRoleTypeEnum::cases() as $projectRoleType) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('project_role_type_translations')->insert([
                        'project_role_type_id' => $projectRoleType->value,
                        'locale_id' => $locale->value,
                        'name' => ProjectRoleTypeTranslationEnum::getName($projectRoleType, $locale),
                        'description' => ProjectRoleTypeTranslationEnum::getDescription($projectRoleType, $locale),
                    ]);
                }
            }
        });
    }
} 