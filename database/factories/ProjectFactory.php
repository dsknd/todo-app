<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProjectStatus;
use App\Models\User;
use App\Models\Project;
use Illuminate\Contracts\Auth\Authenticatable;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'is_private' => $this->faker->boolean,
            'project_status_id' => ProjectStatus::factory(),
            'planned_start_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'planned_end_date' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
            'actual_start_date' => $this->faker->optional(0.7)->dateTimeBetween('-1 month', 'now'),
            'actual_end_date' => $this->faker->optional(0.3)->dateTimeBetween('+1 month', '+6 months'),
            'user_id' => User::factory(),
        ];
    }
}