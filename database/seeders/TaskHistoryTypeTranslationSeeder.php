<?php

namespace Database\Seeders;

use App\Enums\LocaleEnum;
use App\Enums\TaskHistoryTypeEnum;
use App\Enums\TaskHistoryTypeTranslationEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskHistoryTypeTranslationSeeder extends Seeder
{
    public function run(): void
    {
        $translations = [];
        
        foreach (TaskHistoryTypeEnum::cases() as $type) {
            foreach (LocaleEnum::cases() as $locale) {
                $translations[] = [
                    'task_history_type_id' => $type->value,
                    'locale_id' => $locale->value,
                    'name' => TaskHistoryTypeTranslationEnum::getLocalizedName($type, $locale),
                    'description' => TaskHistoryTypeTranslationEnum::getLocalizedDescription($type, $locale),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('task_history_type_translations')->insert($translations);
    }
} 