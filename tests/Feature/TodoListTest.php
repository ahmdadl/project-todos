<?php

namespace Tests\Feature;

use App\Http\Livewire\TodoList;
use App\Http\Livewire\GetTodoList;
use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public Project $project;
    public Todo $todo;
    public User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->project = Project::factory()
            ->has(Todo::factory())
            ->create();
        $this->todo = $this->project->todos->first();
        $this->user = User::factory()->create();
    }

    public function testItWillShowTodoList()
    {
        $this->project->todos()->createMany(
            Todo::factory()
                ->count(5)
                ->raw()
        );

        $this->actingAs($this->user);

        Livewire::test(GetTodoList::class, [
            'project' => $this->project,
        ])
            ->assertSee($this->project->todos->first()->body)
            ->assertSeeLivewire('todo-list');
    }

    public function testUserCanDeleteTodo()
    {
        Livewire::test(TodoList::class, [
            'project' => $this->project,
            'todo' => $this->todo,
        ])
            ->assertSee($this->todo->body)
            ->assertSee('fa-edit')
            ->assertNotEmitted('editTodo')
            ->call('remove')
            ->assertEmitted('todo:deleted');

        $this->assertNull(Todo::find($this->todo->id));
    }

    public function testItCanBeCompleted()
    {
        Livewire::test(TodoList::class, [
            'project' => $this->project,
            'todo' => $this->todo,
        ])
            ->assertSee('fa-trash-alt')
            ->call('check');

        $this->assertTrue(
            Todo::whereBody($this->todo->body)
                ->whereCompleted(!$this->todo->completed)
                ->exists()
        );
    }
}
