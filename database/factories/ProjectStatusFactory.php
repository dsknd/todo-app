<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ProjectStatusEnum;
use App\ValueObjects\ProjectStatusId;
use App\Models\ProjectStatus;
/**
 * @extends Factory<ProjectStatus>
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
        static $id = 1;
        
        return [
            'id' => new ProjectStatusId($id++),
            'key' => 'status_' . uniqid(),
        ];
    }

    public function planning(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'id' => ProjectStatusEnum::PLANNING->value,
            'key' => ProjectStatusEnum::getKey(ProjectStatusEnum::PLANNING),
        ]);
    }

    public function inProgress(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'id' => ProjectStatusEnum::IN_PROGRESS->value,
            'key' => ProjectStatusEnum::getKey(ProjectStatusEnum::IN_PROGRESS),
        ]);
    }

    public function completed(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'id' => ProjectStatusEnum::COMPLETED->value,
            'key' => ProjectStatusEnum::getKey(ProjectStatusEnum::COMPLETED),
        ]);
    }

    public function cancelled(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'id' => ProjectStatusEnum::CANCELLED->value,
            'key' => ProjectStatusEnum::getKey(ProjectStatusEnum::CANCELLED),
        ]);
    }
}
