<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(3)
            ->sequence(
                ['email' => 'admin@site.test'],
                ['email' => 'super@site.test'],
                ['email' => 'user@site.test']
            )
            ->create();

        User::factory()
            ->count(10000)
            ->create();
    }
}
