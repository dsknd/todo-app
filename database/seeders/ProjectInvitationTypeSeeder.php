<?php

namespace Database\Seeders;

use App\Enums\ProjectInvitationType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectInvitationTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [];
        
        foreach (ProjectInvitationType::cases() as $type) {
            $types[] = [
                'id' => $type->value,
                'key' => ProjectInvitationType::getKey($type),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('project_invitation_types')->insert($types);
    }
} 