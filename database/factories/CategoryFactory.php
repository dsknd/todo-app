<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\CategoryEnum;
use App\ValueObjects\CategoryId;
use App\Models\Category;
/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => new CategoryId(CategoryEnum::UNCATEGORIZED->value),
            'key' => CategoryEnum::getKey(CategoryEnum::UNCATEGORIZED),
        ];
    }
}
