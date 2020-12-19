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

    public function testUserIsAdmin()
    {
        $this->assertTrue($this->user->is_admin);
    }

    public function testUserHasManyTeamProjects()
    {
        $project = Project::factory()->create();
        $project->team()->sync($this->user);

        $this->assertCount(1, $this->user->team_projects);
    }
    
    
}
