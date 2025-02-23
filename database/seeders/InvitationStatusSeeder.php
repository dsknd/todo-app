<?php

namespace Database\Seeders;

use App\Enums\InvitationStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvitationStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (InvitationStatusEnum::cases() as $status) {
                DB::table('invitation_statuses')->insert([
                    'id' => $status->value,
                    'key' => InvitationStatusEnum::getKey($status),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
} 