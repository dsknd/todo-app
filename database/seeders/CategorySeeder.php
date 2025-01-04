<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // プロジェクトカテゴリのデータ
        $categories = [
            [
                'name' => 'N/A',
                'description' => 'No category specified.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Software Development',
                'description' => 'Projects related to software development and programming.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Marketing',
                'description' => 'Projects related to marketing campaigns and activities.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Research',
                'description' => 'Projects focused on research and innovation.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Operations',
                'description' => 'Projects related to operations and logistics.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // データを挿入
        DB::table('categories')->insert($categories);
    }
}
