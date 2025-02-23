<?php

namespace Database\Seeders;

use App\Enums\InvitationType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvitationTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [];
        
        foreach (InvitationType::cases() as $type) {
            $types[] = [
                'id' => $type->value,
                'key' => InvitationType::getKey($type),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('invitation_types')->insert($types);
    }
} 