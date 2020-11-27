<?php

namespace Tests\Feature;

use App\Http\Livewire\TodoList;
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

    public function testItWillShowTodoList()
    {
        $cat = Category::factory()->create();
        $user = User::factory()->create();
        $cat->todos()->createMany(
            Todo::factory()
                ->count(5)
                ->raw(['user_id' => $user->id])
        );

        $this->actingAs($user);

        Livewire::test(TodoList::class, [
            "category" => $cat,
        ])
            ->assertSee($cat->title)
            ->assertSee($cat->todos->first()->body);
    }
}
