<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // プロジェクト権限データ
        $projectPermissions = [
            ['permission_id' => 1], // projects: read
            ['permission_id' => 2], // projects: write
            ['permission_id' => 3], // projects: delete
            ['permission_id' => 4], // project_invitations: invite
            ['permission_id' => 5], // project_invitations: approve
            ['permission_id' => 6], // project_invitations: revoke
        ];

        // データの挿入
        DB::table('project_permissions')->insert($projectPermissions);
    }
}
