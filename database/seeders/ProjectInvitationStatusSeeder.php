<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectInvitationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run():void
    {
        DB::table('project_invitation_statuses')->insert([
            ['id' => 1, 'name' => 'Pending', 'description' => 'The invitation is pending.'],
            ['id' => 2, 'name' => 'Accepted', 'description' => 'The invitation has been accepted.'],
            ['id' => 3, 'name' => 'Declined', 'description' => 'The invitation has been declined.'],
        ]);
    }
}
