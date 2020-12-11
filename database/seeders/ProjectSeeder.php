<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();

        User::all()->each(function (User $user) use ($categories) {
            Project::factory()
                ->count(random_int(1, 3))
                ->sequence(
                    ["category_id" => $categories->random()->id],
                    ["category_id" => $categories->random()->id],
                    ["category_id" => $categories->random()->id]
                )
                ->create();
        });
    }
}
