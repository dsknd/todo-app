<?php
namespace Database\Factories;

use App\Models\TodoClosure;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoClosureFactory extends Factory
{
    protected $model = TodoClosure::class;

    public function definition()
    {
        return [
            'ancestor_id' => $this->faker->randomNumber(), // 適宜IDを設定
            'descendant_id' => $this->faker->randomNumber(),
            'depth' => $this->faker->numberBetween(0, 5), // 深さをランダムに設定
        ];
    }
}