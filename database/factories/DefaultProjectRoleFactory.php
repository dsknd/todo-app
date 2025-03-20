<?php

namespace Database\Factories;

use App\Models\DefaultProjectRole;
use App\Models\ProjectRole;
use App\Enums\DefaultProjectRoleEnum;
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

    public function owner(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'project_role_id' => ProjectRole::factory()->create([
                'id' => DefaultProjectRoleEnum::OWNER->value,
            ])->id,
        ]);
    }
} 