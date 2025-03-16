<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\TaskStatusEnum;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskStatus>
 */
class TaskStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => TaskStatusEnum::NOT_STARTED,
            'key' => TaskStatusEnum::getKey(TaskStatusEnum::NOT_STARTED),
        ];
    }
}

