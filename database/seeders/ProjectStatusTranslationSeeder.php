<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ProjectStatusEnum;
use App\Enums\LocaleEnum;
use App\Enums\ProjectStatusTranslationEnum;

class ProjectStatusTranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (ProjectStatusEnum::cases() as $status) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('project_status_translations')->insert([
                        'project_status_id' => $status->value,
                        'locale_id' => $locale->value,
                        'name' => ProjectStatusTranslationEnum::getName($status, $locale),
                        'description' => ProjectStatusTranslationEnum::getDescription($status, $locale),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
} 