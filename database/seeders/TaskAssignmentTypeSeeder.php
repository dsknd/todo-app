<?php

namespace Database\Seeders;

use App\Enums\TaskAssignmentTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskAssignmentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [];
        
        foreach (TaskAssignmentTypeEnum::cases() as $type) {
            $types[] = [
                'id' => $type->value,
                'key' => TaskAssignmentTypeEnum::getKey($type),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('task_assignment_types')->insert($types);
    }
} 