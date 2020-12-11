<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();
        $users = User::all();

        $categories->each(function (Category $category) use ($users) {
            Todo::factory()
                ->count(random_int(5, 10))
                ->create([
                    "user_id" => $users->random()->id,
                    "category_id" => $category->id,
                ]);
        });
    }
}
