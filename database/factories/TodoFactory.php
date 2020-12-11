<?php

namespace Database\Factories;

use App\Models\Project;
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
            'project_id' => fn() => Project::factory()->create()->id,
            'body' => $this->faker->sentence,
            'completed' => (bool) random_int(0, 1),
        ];
    }
}
