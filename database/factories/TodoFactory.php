<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Todo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => fn() => User::factory()->create()->id,
            'category_id' => fn() => Category::factory()->create()->id,
            'body' => $this->faker->sentence,
            'completed' => (bool) random_int(0, 1),
        ];
    }
}
