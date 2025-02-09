<?php

namespace Database\Seeders;

use App\Enums\MilestonePriorityEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MilestonePrioritySeeder extends Seeder
{
    public function run(): void
    {
        $priorities = [];
        
        foreach (MilestonePriorityEnum::cases() as $priority) {
            $priorities[] = [
                'id' => $priority->value,
                'key' => MilestonePriorityEnum::getKey($priority),
                'priority_value' => MilestonePriorityEnum::getPriorityValue($priority),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('milestone_priorities')->insert($priorities);
    }
} 