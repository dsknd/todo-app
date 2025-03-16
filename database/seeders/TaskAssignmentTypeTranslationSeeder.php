<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\TaskAssignmentTypeEnum;
use App\Enums\LocaleEnum;
use App\Enums\TaskAssignmentTypeTranslationEnum;

class TaskAssignmentTypeTranslationSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (TaskAssignmentTypeEnum::cases() as $type) {
                foreach (LocaleEnum::cases() as $locale) {
                    DB::table('task_assignment_type_translations')->insert([
                        'task_assignment_type_id' => $type->value,
                        'locale_id' => $locale->value,
                        'name' => TaskAssignmentTypeTranslationEnum::getName($type, $locale),
                        'description' => TaskAssignmentTypeTranslationEnum::getDescription($type, $locale),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
} 