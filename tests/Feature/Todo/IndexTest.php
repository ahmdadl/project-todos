<?php

namespace Tests\Feature\Todo;

use App\Http\Livewire\Todo\Index as TodoIndex;
use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Livewire\Testing\TestableLivewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Project $project;
    public Todo $todo;
    public TestableLivewire $test;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->project = Project::factory()
            ->has(Todo::factory())
            ->create([
                'user_id' => $this->user->id,
            ]);
        $this->todo = $this->project->todos->first();

        $this->test = Livewire::test(TodoIndex::class);
    }

    public function testItWillShowTodoList()
    {
        $this->signIn($this->user);

        $res = $this->get('/projects/' . $this->project->slug)
            ->assertSee($this->project->name)
            ->assertSee('Add New Task')
            ->assertSee($this->todo->body);
        $res->assertSeeLivewire('todo.create');
        $res->assertSeeLivewire('todo.one');
    }

    public function testOnlyProjectOwnerOrTeamMemberCanViewTodos()
    {
        $anotherUser = User::factory()->create();
        $this->actingAs($anotherUser)
            ->get('/projects/' . $this->project->slug)
            ->assertStatus(403);

        // owner can view project todos
        $this->actingAs($this->user)
            ->get('/projects/' . $this->project->slug)
            ->assertOk()
            ->assertSee($this->todo->body);

        // add user as team member
        $this->project->team()->syncWithoutDetaching($anotherUser);
        // team member can view project todos
        $this->actingAs($anotherUser)
            ->get('/projects/' . $this->project->slug)
            ->assertOk()
            ->assertSee($this->todo->body);
    }
}
