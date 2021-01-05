<?php

namespace Tests\Feature\Todo;

use App\Http\Livewire\Todo\Create;
use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public Project $project;
    public User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->project = Project::factory()
            ->has(Todo::factory())
            ->create();
    }

    public function testOnlyAuthriedUsersCanAddNewTodo()
    {
        $this->post(
            "/projects/" . $this->project->slug . "/todos",
            []
        )->assertRedirect("/login");
    }

    public function testUserCanAddNewTodo()
    {
        $this->signIn($this->user);
        $todo = Todo::factory()->make();

        Livewire::test(Create::class, [
            "project" => $this->project,
            "body" => $todo->body,
        ])
            ->assertSet("body", $todo->body)
            ->call("store")
            ->assertEmitted("todo:saved");

        $this->assertTrue(
            Todo::whereProjectId($this->project->id)
                ->whereBody($todo->body)
                ->exists()
        );

        $this->assertEquals(2, Todo::count());
    }

    public function testUserCanNotAddNewTodoWithInvalidBody()
    {
        $this->signIn();

        Livewire::test(Create::class, [
            "project" => $this->project,
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

        $todo = $this->project->todos->first();

        Livewire::test(Create::class, [
            "project" => $this->project,
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
        $this->assertCount(1, $this->project->todos);
    }
}
