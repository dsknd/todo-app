<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ScheduleDateTypeTranslationEnum;
use App\Enums\ScheduleDateTypeEnum;
use App\Enums\LocaleEnum;

class ScheduleDateTypeTranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (ScheduleDateTypeEnum::cases() as $type) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('schedule_date_type_translations')->insert([
                        'schedule_date_type_id' => $type->value,
                        'locale_id' => $locale->value,
                        'name' => ScheduleDateTypeTranslationEnum::getName($type, $locale),
                        'description' => ScheduleDateTypeTranslationEnum::getDescription($type, $locale),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
} 