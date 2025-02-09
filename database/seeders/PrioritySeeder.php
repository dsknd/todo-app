<?php

namespace Database\Seeders;

use App\Enums\PriorityEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        $priorities = [];
        
        foreach (PriorityEnum::cases() as $priority) {
            $priorities[] = [
                'id' => $priority->value,
                'key' => PriorityEnum::getKey($priority),
                'priority_value' => PriorityEnum::getPriorityValue($priority),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('priorities')->insert($priorities);
    }
} 