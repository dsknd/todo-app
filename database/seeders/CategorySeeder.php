<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Enums\CategoryEnum;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (CategoryEnum::cases() as $category) {
            Category::create([
                'id' => $category->value,
                'display_name' => CategoryEnum::getDisplayName($category->value),
                'description' => CategoryEnum::getDescription($category->value),
            ]);
        }
    }
}
