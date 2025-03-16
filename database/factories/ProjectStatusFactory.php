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
}
