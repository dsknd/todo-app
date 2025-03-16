<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\PriorityEnum;
use App\Enums\LocaleEnum;
use App\Enums\PriorityTranslationEnum;

class PriorityTranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (PriorityEnum::cases() as $priority) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('priority_translations')->insert([
                        'priority_id' => $priority->value,
                        'locale_id' => $locale->value,
                        'name' => PriorityTranslationEnum::getName($priority, $locale),
                        'description' => PriorityTranslationEnum::getDescription($priority, $locale),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
} 