<?php

namespace Database\Seeders;

use App\Enums\TaskHistoryTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskHistoryTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (TaskHistoryTypeEnum::cases() as $type) {
                DB::table('task_history_types')->insert([
                    'id' => $type->value,
                    'key' => strtolower($type->name),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
} 