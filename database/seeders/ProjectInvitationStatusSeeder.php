<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\ProjectInvitationStatuses;

class ProjectInvitationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run():void
    {
        DB::table('project_invitation_statuses')->insert([
            [
                'id' => ProjectInvitationStatuses::PENDING,
                'name' => 'Pending',
                'description' => 'The invitation is pending.'
            ],
            [
                'id' => ProjectInvitationStatuses::ACCEPTED,
                'name' => 'Accepted',
                'description' => 'The invitation has been accepted.'
            ],
            [
                'id' => ProjectInvitationStatuses::DECLINED,
                'name' => 'Declined',
                'description' => 'The invitation has been declined.'
            ],
        ]);
    }
}
