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

    public function testItHasSlug()
    {
        $cat = Category::factory()->create();

        $this->assertIsString($cat->slug);
    }
}
