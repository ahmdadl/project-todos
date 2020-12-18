<?php

namespace Tests\Feature;

use App\Http\Livewire\OneProject;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Livewire\Testing\TestableLivewire;
use Tests\TestCase;

class OneProjectTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

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
            ->assertEmitted(
                'project:edit',
                $this->project->slug,
                $this->project->category->slug
            );
    }

    public function testUserCanDeleteProject()
    {
        $this->signIn($this->user);

        $this->test
            ->call('toggleModal')
            ->assertSet('openModal', true)
            ->call('destroy', $this->project->slug)
            ->assertEmitted('project:deleted');

        $this->assertFalse(Project::whereSlug($this->project->slug)->exists());
    }

    public function testUserCanToggleCompletedState()
    {
        $this->test->call('toggleCompleted'); // ->assertEmitted()
    }

    public function testUserCanAddNewMembersToProjectTeam()
    {
        $user = User::factory()->create();

        $this->project->setTable('projects');
        $this->project->wasRecentlyCreated = false;
        $this->project->update();
        $this->project->refresh();

        // it will show error if email is not valid
        $this->test
            ->set('teamUserMail', 'sadasdasd')
            ->call('addUserToTeam')
            ->assertHasErrors();

        // it will show error if email not registered
        $this->test
            ->set('teamUserMail', $this->faker->email)
            ->call('addUserToTeam')
            ->assertHasErrors();

        // it will add user to team
        $comp = $this->test
            ->call('toggleTeamModal')
            ->assertSet('teamModal', true)
            ->set('teamUserMail', $user->email)
            ->call('addUserToTeam')
            ->assertHasNoErrors()
            ->tap(fn() => $this->project->load('team'))
            ->assertSet('project', $this->project);
    }

    public function testOnlyProjectOwnerCanDeleteIt()
    {
        $anotherUser = User::factory()->create();
        $this->project->team()->syncWithoutDetaching($anotherUser);

        $this->test
            ->call('destroy')
            ->assertNotEmitted('project:deleted', $this->project->slug);

        $this->assertTrue(
            Project::whereSlug($this->project->slug)->exists()
        );
    }
}
