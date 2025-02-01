<?php

namespace Database\Seeders;

use App\Enums\ProjectInvitationStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectInvitationStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (ProjectInvitationStatusEnum::cases() as $status) {
                DB::table('project_invitation_statuses')->insert([
                    'id' => $status->value,
                    'display_name' => $status->getDisplayName($status->value),
                    'description' => $status->getDescription($status->value),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
} 