<?php

namespace Database\Seeders;

use App\Enums\UrgencyLevelEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UrgencyLevelSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (UrgencyLevelEnum::cases() as $urgency) {
                DB::table('urgency_levels')->insert([
                    'id' => $urgency->value,
                    'display_name' => UrgencyLevelEnum::getDisplayName($urgency->value),
                    'urgency_level' => UrgencyLevelEnum::getUrgencyLevel($urgency->value),
                    'description' => UrgencyLevelEnum::getDescription($urgency->value),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
} 