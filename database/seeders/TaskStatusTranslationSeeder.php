<?php

namespace Database\Seeders;

use App\Enums\LocaleEnum;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskStatusTranslationEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusTranslationSeeder extends Seeder
{
    /**
     * 翻訳データを登録
     */
    public function run(): void
    {
        DB::transaction(function () {
            foreach (TaskStatusEnum::cases() as $status) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('task_status_translations')->insert([
                        'task_status_id' => $status->value,
                        'locale_id' => $locale->value,
                        'name' => TaskStatusTranslationEnum::getLocalizedName($status, $locale),
                        'description' => TaskStatusTranslationEnum::getLocalizedDescription($status, $locale),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
} 