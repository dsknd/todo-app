<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // シーダーデータ
        $taskCategories = [
            [
                'name' => 'General',
                'description' => 'General tasks category',
                'is_custom' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Development',
                'description' => 'Tasks related to development',
                'is_custom' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Testing',
                'description' => 'Tasks for testing and QA',
                'is_custom' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Design',
                'description' => 'Tasks for design team',
                'is_custom' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // データベースに挿入
        DB::table('task_categories')->insert($taskCategories);
    }
}
