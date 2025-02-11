<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ProjectStatusEnum;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectStatus>
 */
class ProjectStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => ProjectStatusEnum::PLANNING->value,
            'key' => ProjectStatusEnum::getKey(ProjectStatusEnum::PLANNING),
        ];
    }
}
