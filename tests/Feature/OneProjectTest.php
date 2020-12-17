<?php

namespace Tests\Feature;

use App\Http\Livewire\OneProject;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Tests\TestCase;

class OneProjectTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Project $project;

    protected function setUp(): void
    {
        parent::setUp();

        $this->project = Project::factory()->create();
        $this->user = $this->project->owner;
    }

    public function testUserCanDeleteProject()
    {
        $this->signIn($this->user);

        Livewire::test(OneProject::class, [
            'user' => $this->user,
            'project' => $this->project,
        ])
            ->call('destroy', 1)
            ->assertEmitted('project:deleted');

        $this->assertFalse(Project::whereSlug($this->project->slug)->exists());
    }
}
