<?php

namespace Tests\Feature;

use App\Events\RefreshCachedCategoryList;
use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Cache;
use Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCategoryListTest extends TestCase
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

        Project::factory()
            ->count(4)
            ->raw([
                "category_id" => $cats->first->id,
            ]);

        Project::factory()->create();

        $this->withoutExceptionHandling();

        $this->actingAs($this->user)
            ->get("/categories")
            ->assertOk()
            ->assertSee($this->user->name)
            ->assertSee($cats->random()->title)
            ->assertSee($cats->random()->title)
            ->assertSee(4);
    }

    // public function testListWillBeUpdatedAfterAddingNewProject()
    // {
    //     $this->signIn($this->user);

    //     Event::fakeFor(function () {
    //         $this->category->projects()->createMany(
    //             Project::factory()
    //                 ->count(15)
    //                 ->raw([
    //                     "category_id" => $this->category->id,
    //                 ])
    //         );
    //     });

    //     $this->get("/categories")
    //         ->assertSee($this->category->title)
    //         ->assertSeeText("15\r\n")
    //         ->assertDontSeeText("16\r\n");

    //     $this->category->projects()->create(
    //         Project::factory()->raw([
    //             "category_id" => $this->category->id,
    //         ])
    //     );

    //     $this->get("/categories")
    //         ->assertSee($this->category->title)
    //         ->assertSeeText("16\r\n")
    //         ->assertDontSeeText("15\r\n");
    // }

    public function testDeletingTodoWillRefreshCachedCategoryList()
    {
        $this->signIn($this->user);

        Event::fakeFor(function () {
            $this->category->projects()->createMany(
                Project::factory()
                    ->count(15)
                    ->raw([
                        "category_id" => $this->category->id,
                    ])
            );
        });

        $this->get("/categories")
            ->assertSee($this->category->title)
            ->assertSeeText("15\r\n")
            ->assertDontSeeText("16\r\n");

        $todo = $this->category->projects->first();
        $todo->delete();

        $this->get("/categories")
            ->assertSee($this->category->title)
            ->assertSee("14\r\n")
            ->assertDontSee("15\r\n");
    }
}
