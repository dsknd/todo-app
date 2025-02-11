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
            'name' => fake()->name(),
            'description' => fake()->text(),
            'is_private' => false,
            'project_status_id' => ProjectStatus::factory(),
            'user_id' => User::factory(),
        ];
    }
}