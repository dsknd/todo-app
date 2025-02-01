<?php

namespace Database\Seeders;

use App\Enums\ProjectInvitationTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectInvitationTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach (ProjectInvitationTypeEnum::cases() as $type) {
                DB::table('project_invitation_types')->insert([
                    'id' => $type->value,
                    'display_name' => $type->getDisplayName($type->value),
                    'description' => $type->getDescription($type->value),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
} 