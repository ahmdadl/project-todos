<?php

namespace Database\Seeders;

use App\Models\Project;
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
        $projects = Project::all();

        $projects->each(function (Project $project) {
            Todo::factory()
                ->count(random_int(5, 10))
                ->create([
                    "project_id" => $project->id,
                ]);
        });
    }
}
