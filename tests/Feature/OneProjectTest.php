<?php

namespace Tests\Feature;

use App\Http\Livewire\AddProject;
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
    public User $teamUser;
    public User $anyOne;
    public Project $project;
    public TestableLivewire $test;

    protected function setUp(): void
    {
        parent::setUp();

        $this->project = Project::factory()->create();
        $this->user = $this->project->owner;
        $this->teamUser = User::factory()->create();
        $this->project->team()->syncWithoutDetaching($this->teamUser);
        $this->project->refresh();

        $this->anyOne = User::factory()->create();

        $this->test = Livewire::test(OneProject::class, [
            'project' => $this->project,
            'user' => $this->user,
        ]);
    }

    public function testProjectCanBeEdited()
    {
        $this->signIn($this->user);
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
            ->call('destroy')
            ->assertEmitted('project:deleted');

        $this->assertFalse(Project::whereSlug($this->project->slug)->exists());
    }

    public function testUserCanToggleCompletedState()
    {
        $this->test->call('toggleCompleted'); // ->assertEmitted()
    }

    public function testUserCanAddNewMembersToProjectTeam()
    {
        $this->signIn($this->user);

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
        $this->signIn($this->teamUser);
        $this->test
            ->call('destroy')
            ->assertNotEmitted('project:deleted', $this->project->slug);

        $this->assertTrue(Project::whereSlug($this->project->slug)->exists());
    }

    public function testOnlyProjectOwnerCanAddTeamMembers()
    {
        $this->assertCount(1, $this->project->team);

        // team member can not add new member
        $this->actingAs($this->teamUser);
        $this->test
            ->set('teamUserMail', User::latest()->first()->email)
            ->call('addUserToTeam')
            ->assertHasNoErrors();

        // owner can add new members
        $this->actingAs($this->user);
        $this->test
            ->set('teamUserMail', User::latest()->first()->email)
            ->call('addUserToTeam')
            ->assertHasNoErrors();
    }

    public function testAnyOneCanNotUpdateProject()
    {
        $this->signIn($this->anyOne);
        $this->test
            ->call('edit')
            ->assertNotEmitted(
                'project:edit',
                $this->project->slug,
                $this->project->category->slug
            );

        Livewire::test(AddProject::class)
            ->set('editMode', true)
            ->call('save')
            ->assertNotEmitted('project:updated', $this->project->slug);

        $this->assertTrue(
            Project::whereUpdatedAt($this->project->updated_at)->exists()
        );
    }

    public function testProjectOwnerOrTeamMebmersCanUpdateProject()
    {
        $this->signIn($this->teamUser);

        $this->test
            ->call('edit')
            ->assertEmitted(
                'project:edit',
                $this->project->slug,
                $this->project->category->slug
            );

        Livewire::test(AddProject::class)
            ->emit(
                'project:edit',
                $this->project->slug,
                $this->project->category->slug
            )
            ->set('cost', 222)
            ->call('save')
            ->assertEmitted('project:updated', $this->project->slug);

        $this->assertTrue(Project::whereCost(222)->exists());
    }

    public function testOnlyProjectOwnerOrTeamMemberCanMakeAsComplete()
    {
        $this->signIn($this->anyOne);
        $this->test->call('toggleCompleted');
        $this->assertDatabaseMissing('projects', [
            'name' => $this->project->name,
            'completed' => !$this->project->completed,
        ]);

        $this->signIn($this->teamUser);
        $this->test->call('toggleCompleted');
        $this->assertTrue(
            Project::whereSlug($this->project->slug)
                ->whereCompleted(!$this->project->completed)
                ->exists()
        );
    }
}
