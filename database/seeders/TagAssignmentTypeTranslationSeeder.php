<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\TagAssignmentTypeEnum;
use App\Enums\LocaleEnum;
use App\Enums\TagAssignmentTypeTranslationEnum;

class TagAssignmentTypeTranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (TagAssignmentTypeEnum::cases() as $type) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('tag_assignment_type_translations')->insert([
                        'tag_assignment_type_id' => $type->value,
                        'locale_id' => $locale->value,
                        'name' => TagAssignmentTypeTranslationEnum::getName($type, $locale),
                        'description' => TagAssignmentTypeTranslationEnum::getDescription($type, $locale),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
} 