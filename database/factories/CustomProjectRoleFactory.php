<?php

namespace Database\Factories;

use App\Models\CustomProjectRole;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProjectRole;

class CustomProjectRoleFactory extends Factory
{
    protected $model = CustomProjectRole::class;

    public function definition()
    {
        return [
            'project_role_id' => ProjectRole::factory(),
            'project_id' => Project::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];
    }
}
