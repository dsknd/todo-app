<?php

namespace Database\Factories;

use App\Models\ProjectRoleType;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\ValueObjects\ProjectRoleTypeId;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectRoleType>
 */
class ProjectRoleTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectRoleType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $id = 1;

        return [
            'id' => new ProjectRoleTypeId($id++),
            'key' => $this->faker->unique()->word(),
        ];
    }
}