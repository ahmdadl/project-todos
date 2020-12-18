<?php

namespace Tests\Feature;

use App\Http\Livewire\OneProject;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Livewire\Testing\TestableLivewire;
use Tests\TestCase;

class OneProjectTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Project $project;
    public TestableLivewire $test;

    protected function setUp(): void
    {
        parent::setUp();

        $this->project = Project::factory()->create();
        $this->user = $this->project->owner;

        $this->test = Livewire::test(OneProject::class, [
            'project' => $this->project,
            'user' => $this->user,
        ]);
    }

    public function testProjectCanBeEdited()
    {
        $this->test
            ->call('edit')
            ->assertEmitted('project:edit', $this->project->slug);
    }

    public function testUserCanDeleteProject()
    {
        $this->signIn($this->user);

        $this->test->call('destroy', 1)->assertEmitted('project:deleted');

        $this->assertFalse(Project::whereSlug($this->project->slug)->exists());
    }
}
