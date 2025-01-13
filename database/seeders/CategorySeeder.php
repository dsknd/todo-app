<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Categories;
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
                'id' => Categories::NA,
                'name' => 'N/A',
                'description' => 'No category specified.',
            ],
            [
                'id' => Categories::SOFTWARE_DEVELOPMENT,
                'name' => 'Software Development',
                'description' => 'Projects related to software development and programming.',
            ],
            [
                'id' => Categories::MARKETING,
                'name' => 'Marketing',
                'description' => 'Projects related to marketing campaigns and activities.',
            ],
            [
                'id' => Categories::RESEARCH,
                'name' => 'Research',
                'description' => 'Projects focused on research and innovation.',
            ],
            [
                'id' => Categories::OPERATIONS,
                'name' => 'Operations',
                'description' => 'Projects related to operations and logistics.',
            ],
        ];

        // データを挿入
        DB::table('categories')->insert($categories);
    }
}
