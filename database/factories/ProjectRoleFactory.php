<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectRole;
use App\Models\ProjectRoleType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectRole>
 */
class ProjectRoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectRole::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_role_type_id' => ProjectRoleType::factory(),
            'assignable_limit' => $this->faker->numberBetween(1, 10),
            'assigned_count' => $this->faker->numberBetween(0, 10),
        ];
    }
}