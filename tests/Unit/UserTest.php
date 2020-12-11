<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testUserHasManyProjects()
    {
        Project::factory()
            ->count(5)
            ->sequence(["user_id" => $this->user->id])
            ->create();

        $this->assertCount(5, $this->user->projects);
    }
}
