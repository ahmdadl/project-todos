<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCategoryListTest extends TestCase
{
    use RefreshDatabase;

    public function testItWillShowCategoryList()
    {
        $user = User::factory()->create();
        Category::factory()->create();
        $cats = Category::all();

        Todo::factory()->count(4)->raw([
            'user_id' => $user->id,
            'category_id' => $cats->first->id
        ]);

        Todo::factory()->create();

        $this->actingAs($user)
            ->get('/categories')
            ->assertOk()
            ->assertSee($user->name)
            ->assertSee($cats->random()->title)
            ->assertSee($cats->random()->title)
            ->assertSee(4);
    }
    
}
