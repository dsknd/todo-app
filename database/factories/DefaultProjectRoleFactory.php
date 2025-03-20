<?php

namespace Database\Factories;

use App\Models\DefaultProjectRole;
use App\Models\ProjectRole;
use Illuminate\Database\Eloquent\Factories\Factory;
class DefaultProjectRoleFactory extends Factory
{
    protected $model = DefaultProjectRole::class;

    public function definition(): array
    {
        return [
            'project_role_id' => ProjectRole::factory(),
            'key' => $this->faker->unique()->word(),
        ];
    }
} 