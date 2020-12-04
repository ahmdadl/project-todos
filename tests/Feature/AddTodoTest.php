<?php

namespace Tests\Feature;

use App\Http\Livewire\AddTodo;
use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Tests\TestCase;

class AddTodoTest extends TestCase
{
    use RefreshDatabase;

    public Category $category;
    public User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Category::factory()
            ->has(Todo::factory())
            ->create();
    }

    public function testOnlyAuthriedUsersCanAddNewTodo()
    {
        $this->post(
            "/categories/" . $this->category->slug . "/todos",
            []
        )->assertRedirect("/login");
    }

    public function testUserCanAddNewTodo()
    {
        $this->signIn($this->user);
        $todo = Todo::factory()->make();

        Livewire::test(AddTodo::class, [
            "category" => $this->category,
            "body" => $todo->body,
        ])
            ->assertSet("body", $todo->body)
            ->call("store")
            ->assertEmitted("todo:saved");

        $this->assertTrue(
            Todo::whereUserId($this->user->id)
                ->whereBody($todo->body)
                ->exists()
        );
    }

    public function testUserCanNotAddNewTodoWithInvalidBody()
    {
        $this->signIn();

        Livewire::test(AddTodo::class, [
            "category" => $this->category,
            "body" => "as23",
        ])
            ->assertSet("body", "as23")
            ->call("store")
            ->assertHasErrors(["body"])
            ->assertNotEmitted("todo:saved");
    }

    public function testEditModeCanBeEnabled()
    {
        $this->signIn();

        $todo = $this->category->todos->first();

        Livewire::test(AddTodo::class, [
            "category" => $this->category,
        ])
            ->emit("editTodo", $todo->id)
            ->assertSet("todo", $todo)
            ->assertSet("editMode", true)
            ->assertSet("body", $todo->body)
            ->assertDispatchedBrowserEvent("edit-mode")
            ->set("body", $todo->body . "25")
            ->call("submit")
            ->assertEmitted("todo:updated")
            // disableEditMode method was called
            ->assertSet('body', '')
            ->assertSet('editMode', false);

        $this->assertTrue(Todo::whereBody($todo->body . "25")->exists());

        // store method was not called
        $this->assertCount(1, $this->category->todos);
    }
}
