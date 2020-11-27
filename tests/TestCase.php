<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn(?User $user = null, array $attr = []): User
    {
        $user = $user ?? User::factory()->create($attr);

        $this->actingAs($user);

        return $user;
    }
}
