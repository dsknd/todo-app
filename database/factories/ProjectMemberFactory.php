<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use App\Models\ProjectRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectMemberFactory extends Factory
{
    protected $model = ProjectMember::class;

    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'user_id' => User::factory(),
            'role_id' => ProjectRole::factory(),
            'joined_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}