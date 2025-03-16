<?php

namespace Database\Seeders;

use App\Enums\TagAssignmentTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagAssignmentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [];
        
        foreach (TagAssignmentTypeEnum::cases() as $type) {
            $types[] = [
                'id' => $type->value,
                'key' => TagAssignmentTypeEnum::getKey($type),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('tag_assignment_types')->insert($types);
    }
} 