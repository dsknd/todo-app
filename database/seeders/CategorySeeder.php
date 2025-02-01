<?php

namespace Database\Seeders;

use App\Enums\CategoryEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            foreach (CategoryEnum::cases() as $category) {
                DB::table('categories')->insert([
                    'id' => $category->value,
                    'name' => CategoryEnum::getDisplayName($category),
                    'description' => CategoryEnum::getDescription($category),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
