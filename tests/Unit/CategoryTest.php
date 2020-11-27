<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Todo;
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
    
}
