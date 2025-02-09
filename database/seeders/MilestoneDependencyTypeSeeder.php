<?php

namespace Database\Seeders;

use App\Enums\MilestoneDependencyTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MilestoneDependencyTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [];
        
        foreach (MilestoneDependencyTypeEnum::cases() as $type) {
            $types[] = [
                'id' => $type->value,
                'key' => MilestoneDependencyTypeEnum::getKey($type),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('milestone_dependency_types')->insert($types);
    }
} 