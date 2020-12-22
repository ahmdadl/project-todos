<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Arr;
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
        Project::unsetEventDispatcher();
        $name = $this->faker->unique()->sentence;
        $img = random_int(1, 4);
        return [
            'user_id' => fn() => User::factory()->create()->id,
            'category_id' => fn() => Category::factory()->create()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'cost' => $this->faker->randomFloat(2, 1, 10000),
            'image' => 'projects/' . $img . '.jpg',
            'completed' => $this->faker->boolean,
        ];
    }
}
