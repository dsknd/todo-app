<?php

namespace Database\Seeders;

use App\Enums\ImportanceLevelEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImportanceLevelSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (ImportanceLevelEnum::cases() as $importance) {
                DB::table('importance_levels')->insert([
                    'id' => $importance->value,
                    'display_name' => ImportanceLevelEnum::getDisplayName($importance->value),
                    'importance_level' => ImportanceLevelEnum::getImportanceLevel($importance->value),
                    'description' => ImportanceLevelEnum::getDescription($importance->value),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
} 