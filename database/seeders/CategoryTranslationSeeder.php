<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\CategoryEnum;
use App\Enums\LocaleEnum;
use App\Enums\CategoryTranslationEnum;
class CategoryTranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (CategoryEnum::cases() as $category) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('category_translations')->insert([
                        'category_id' => $category->value,
                        'locale_id' => $locale->value,
                        'name' => CategoryTranslationEnum::getName($category, $locale),
                        'description' => CategoryTranslationEnum::getDescription($category, $locale),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
} 