<?php

namespace Tests;

use App\Models\User;
use Config;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // $this->signIn();

        Config::set('broadcasting', null);
    }

    public function signIn(?User $user = null, array $attr = []): User
    {
        $user = $user ?? User::factory()->create($attr);

        $this->actingAs($user);

        return $user;
    }
}
