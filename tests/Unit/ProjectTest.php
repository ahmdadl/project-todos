<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Category $category;
    public Project $project;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
        $this->project = Project::factory()->create([
            "user_id" => $this->user->id,
            "category_id" => $this->category->id,
            "slug" => null,
        ]);
    }

    public function testItBelongsToCategory()
    {
        $this->assertNotNull($this->project->category);
    }

    public function testProjectHasSlug()
    {
        $this->assertIsString($this->project->slug);
    }

    public function testProjectBelongsToUser()
    {
        $this->assertNotNull($this->project->owner);
    }
    
    public function testProjectHasTodos()
    {
        $this->assertInstanceOf(
            HasMany::class,
            $this->project->todos()
        );
    }
    
}
