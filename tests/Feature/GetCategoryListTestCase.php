<?php

namespace Tests\Feature;

use App\Events\RefreshCachedCategoryList;
use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Cache;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCategoryListTestCase extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
    }

    public function testItWillShowCategoryList()
    {
        $cats = Category::all();

        Todo::factory()
            ->count(4)
            ->raw([
                "user_id" => $this->user->id,
                "category_id" => $cats->first->id,
            ]);

        Todo::factory()->create();

        $this->actingAs($this->user)
            ->get("/categories")
            ->assertOk()
            ->assertSee($this->user->name)
            ->assertSee($cats->random()->title)
            ->assertSee($cats->random()->title)
            ->assertSee(4);
    }

    public function testListWillBeUpdatedAfterAddingNewTodo()
    {
        $this->signIn($this->user);

        Event::fakeFor(function () {
            $this->category->todos()->createMany(
                Todo::factory()
                    ->count(15)
                    ->raw([
                        "user_id" => $this->user->id,
                        "category_id" => $this->category->id,
                    ])
            );
        });

        $this->get("/categories")
            ->assertSee($this->category->title)
            ->assertSeeText("15\r\n")
            ->assertDontSeeText("16\r\n");

        $this->category->todos()->create(
            Todo::factory()->raw([
                "category_id" => $this->category->id,
                "user_id" => auth()->id(),
            ])
        );

        $this->get("/categories")
            ->assertSee($this->category->title)
            ->assertSeeText("16\r\n")
            ->assertDontSeeText("15\r\n");
    }

    public function testDeletingTodoWillRefreshCachedCategoryList()
    {
        $this->signIn($this->user);

        Event::fakeFor(function () {
            $this->category->todos()->createMany(
                Todo::factory()
                    ->count(15)
                    ->raw([
                        "user_id" => $this->user->id,
                        "category_id" => $this->category->id,
                    ])
            );
        });

        $this->get("/categories")
            ->assertSee($this->category->title)
            ->assertSeeText("15\r\n")
            ->assertDontSeeText("16\r\n");

        $todo = $this->category->todos->first();
        $todo->delete();

        $this->get("/categories")
            ->assertSee($this->category->title)
            ->assertSee("14\r\n")
            ->assertDontSee("15\r\n");
    }
}
