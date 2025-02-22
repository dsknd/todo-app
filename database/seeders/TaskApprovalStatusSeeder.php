<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\TaskApprovalStatusEnum;

class TaskApprovalStatusSeeder extends Seeder
{
    public function run(): void
    {
        foreach (TaskApprovalStatusEnum::cases() as $status) {
            DB::table('task_approval_statuses')->insert([
                'id' => $status->value,
                'key' => $status->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
} 