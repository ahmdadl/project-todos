<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->run(UserSeeder::class);
        $this->run(CategorySeeder::class);
        $this->run(TodoSeeder::class);
    }
}
