<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ステータスのデータを挿入
        $statuses = [
            [
                'name' => 'Pending',
                'description' => 'Project is waiting to start',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In Progress',
                'description' => 'Project is currently in progress',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Completed',
                'description' => 'Project has been completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cancelled',
                'description' => 'Project has been cancelled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // データを挿入
        DB::table('project_statuses')->insert($statuses);
    }
}
