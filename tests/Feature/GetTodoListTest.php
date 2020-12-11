<?php

namespace Tests\Feature;

use App\Http\Livewire\GetTodoList;
use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Tests\TestCase;

class GetTodoListTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Project $project;
    public Todo $todo;

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
    }

    public function testItWillShowTodoList()
    {
        $this->signIn($this->user);

        $res = $this->get('/projects/' . $this->project->slug)
            ->assertSee($this->project->name)
            ->assertSee('Add New Task')
            ->assertSee($this->todo->body);
        $res->assertSeeLivewire('add-todo');
        $res->assertSeeLivewire('todo-list');
    }
}
