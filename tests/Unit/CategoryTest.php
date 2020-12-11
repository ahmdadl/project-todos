<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Project;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->create();
    }

    public function testItHasSlug()
    {
        $this->assertIsString($this->category->slug);
    }

    public function testCategoryHasProjects()
    {
        $this->assertInstanceOf(HasMany::class, $this->category->projects());
    }
}
