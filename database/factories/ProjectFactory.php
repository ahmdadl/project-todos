<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->sentence;
        return [
            "user_id" => fn() => User::factory()->create()->id,
            "category_id" => fn() => Category::factory()->create()->id,
            "name" => $name,
            "slug" => Str::slug($name),
            "cost" => $this->faker->randomFloat(2, 1, 10000),
            "completed" => $this->faker->boolean,
        ];
    }
}
