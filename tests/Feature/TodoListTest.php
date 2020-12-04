<?php

namespace Tests\Feature;

use App\Http\Livewire\TodoList;
use App\Http\Livewire\GetTodoList;
use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public Category $category;
    public Todo $todo;
    public User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()
            ->has(Todo::factory())
            ->create();
        $this->todo = $this->category->todos->first();
        $this->user = User::find($this->todo->user_id);
    }

    public function testItWillShowTodoList()
    {
        $this->category->todos()->createMany(
            Todo::factory()
                ->count(5)
                ->raw(["user_id" => $this->user->id])
        );

        $this->actingAs($this->user);

        Livewire::test(GetTodoList::class, [
            "category" => $this->category,
        ])
            ->assertSee($this->category->todos->first()->body)
            ->assertSeeLivewire("todo-list");
    }

    public function testUserCanDeleteTodo()
    {
        Livewire::test(TodoList::class, [
            "category" => $this->category,
            "todo" => $this->todo,
        ])
            ->assertSee($this->todo->body)
            ->assertSee("fa-edit")
            ->assertNotEmitted("editTodo")
            ->call("remove")
            ->assertEmitted("todo:deleted");

        $this->assertNull(Todo::find($this->todo->id));
    }

    public function testItCanBeCompleted()
    {
        Livewire::test(TodoList::class, [
            "category" => $this->category,
            "todo" => $this->todo,
        ])
            ->assertSee("fa-trash-alt")
            ->call("check");

        $this->assertTrue(
            Todo::whereBody($this->todo->body)
                ->whereCompleted(!$this->todo->completed)
                ->exists()
        );
    }
}
