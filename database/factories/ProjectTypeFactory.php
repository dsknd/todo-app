<?php

namespace Database\Factories;

use App\Models\ProjectType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectTypeFactory extends Factory
{
    protected $model = ProjectType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'user_id' => User::factory(),
        ];
    }
}