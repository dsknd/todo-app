<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $taskTypes = [
            [
                'name' => 'Personal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Project',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // データベースに挿入
        DB::table('task_types')->insert($taskTypes);
    }
}
