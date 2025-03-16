<?php

namespace Database\Seeders;

use App\Enums\ScheduleDateTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleDateTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [];
        
        foreach (ScheduleDateTypeEnum::cases() as $type) {
            $types[] = [
                'id' => $type->value,
                'key' => ScheduleDateTypeEnum::getKey($type),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('schedule_date_types')->insert($types);
    }
} 