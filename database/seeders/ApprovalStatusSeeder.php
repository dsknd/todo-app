<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ApprovalStatusEnum;

class ApprovalStatusSeeder extends Seeder
{
    public function run(): void
    {
        foreach (ApprovalStatusEnum::cases() as $status) {
            DB::table('approval_statuses')->insert([
                'id' => $status->value,
                'key' => $status->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
} 