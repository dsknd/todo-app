<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\PriorityEnum;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Priority>
 */
class PriorityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => PriorityEnum::NONE,
            'key' => PriorityEnum::getKey(PriorityEnum::NONE),
            'priority_value' => PriorityEnum::getPriorityValue(PriorityEnum::NONE),
        ];
    }
}
