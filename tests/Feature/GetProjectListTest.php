<?php

namespace Tests\Feature;

use App\Http\Livewire\GetProjectList;
use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Livewire\Testing\TestableLivewire;
use Tests\TestCase;

class GetProjectListTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public Category $category;
    public Collection $projects;
    public Project $project;
    public TestableLivewire $test;

    protected function setUp(): void
    {
        parent::setUp();

        $this->projects = Project::factory()
            ->count(4)
            ->for(Category::factory())
            ->create();

        $this->project = $this->projects->first();
        $this->category = $this->project->category;
        $this->user = $this->project->owner;

        $this->signIn($this->user);

        $this->test = Livewire::test(GetProjectList::class);
    }

    public function testItWillPrependProjectAndApplyFilters()
    {
        $project = Project::factory([
            'user_id' => $this->user->id,
            'cost' => 556.32,
            'completed' => 1,
            'category_id' => $this->projects->first()->category_id,
        ])->raw();

        $query = Project::whereUserId($this->user->id)
            ->with(['category', 'team'])
            ->withCount('todos');

        Livewire::test(GetProjectList::class)
            ->assertSee('add new project')
            ->assertSet('allProjects', $query->get())
            ->call('sortByHighCost')
            ->assertSet('sortBy', 'desc')
            ->assertSet('allProjects', $query->orderByDesc('cost')->get())
            ->assertNotEmitted('modal:close')
            ->call('appendProject', $this->createProject($project)->slug)
            ->assertEmitted('modal:close')
            ->assertSee($this->project->name)
            ->call('showOnlyCompleted')
            ->assertSet('onlyCompleted', true)
            // only projects collection should contain only
            // completed projects
            ->assertNotSet(
                'allProjects',
                $query
                    ->whereCompleted(true)
                    ->orderByDesc('cost')
                    ->get()
            )
            ->assertSee('completed');
    }

    public function testProjectWillRemovedFromListAfterDeleting()
    {
        Livewire::test(GetProjectList::class)
            ->assertSee($this->project->name)
            ->emit('project:deleted', 1)
            ->assertDontSee($this->project->name);
    }

    public function testProjectWillBeUpdated()
    {
        $this->test
            ->emit('project:updated', $this->project->slug)
            ->assertEmitted('modal:close');
    }

    private function createProject(array $attrs): Project
    {
        $this->project = Project::create($attrs);

        $this->project->loadMissing(['category', 'team']);
        $this->project->refresh();

        return $this->project;
    }
}
