<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testItHasTodos()
    {
        $cat = Category::factory()->create();

        $this->assertNotNull($cat->todos);

        $cat->todos()->create(Todo::factory()->raw());

        $cat->refresh();

        $this->assertCount(1, $cat->todos);
    }

    public function testItHasSlug()
    {
        $cat = Category::factory()->create();

        $this->assertIsString($cat->slug);
    }

    public function testItCanGetTodosCountForCurrentUser()
    {
        $cat = Category::factory()->create();
        $user = User::factory()->create();

        $todos = Todo::factory()->count(4)->create([
            'category_id' => $cat->id,
            'user_id' => $user->id,
        ]);

        Todo::factory()->count(3)->create([
            'category_id' => $cat->id,
        ]);

        $this->actingAs($user);

        $this->assertEquals(7, (Category::withCount('todos')->first())->todos_count);

        $this->assertEquals(
            4,
            Category::withCount('my_todos')->first()->my_todos_count
        );
    }
    
}
