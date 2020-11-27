<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\Todo;
use App\Models\User;
use DB;
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
        DB::beginTransaction();
        
        $categories = Category::all();
        $users = User::all();
        
        $categories->each(function (Category $category) use ($users) {
            $category->todos()->createMany(
                Todo::factory()->count(5)->raw([
                    'user_id' => $users->random()
                ])
            );
        });

        DB::commit();
    }
}
