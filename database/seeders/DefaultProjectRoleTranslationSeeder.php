<?php

namespace Database\Seeders;

use App\Enums\DefaultProjectRoleEnum;
use App\Enums\LocaleEnum;
use App\Enums\DefaultProjectRoleTranslationEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultProjectRoleTranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (DefaultProjectRoleEnum::cases() as $role) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('default_project_role_translations')->insert([
                        'project_role_id' => $role->value,
                        'locale_id' => $locale->value,
                        'name' => DefaultProjectRoleTranslationEnum::getName($role, $locale),
                        'description' => DefaultProjectRoleTranslationEnum::getDescription($role, $locale),
                    ]);
                }
            }
        });
    }
}