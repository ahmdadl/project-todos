<?php

namespace Database\Seeders;

use App\Models\User;
use DB;
use Event;
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
        // disable event
        Event::fake();

        DB::beginTransaction();

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            TodoSeeder::class,
        ]);

        DB::commit();
    }
}
