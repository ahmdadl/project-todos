<?php

namespace Tests\Feature\Project;

use App\Http\Livewire\Project\Index;
use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Livewire\Testing\TestableLivewire;
use Tests\TestCase;

class IndexTest extends TestCase
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

        $this->user = User::factory()->create();
        $this->projects = Project::factory()
            ->count(4)
            ->for(Category::factory())
            ->sequence(['user_id' => $this->user->id])
            ->create();

        $this->project = $this->projects->first();
        $this->category = $this->project->category;

        $this->signIn($this->user);

        $this->test = Livewire::test(Index::class);
    }

    public function testItWillPrependProjectAndApplyFilters()
    {
        Project::factory()->create([
            'completed' => false,
            'user_id' => $this->user->id,
            'category_id' => $this->projects->first()->category_id,
        ]);

        $project = Project::factory([
            'user_id' => $this->user->id,
            'cost' => 556.32,
            'completed' => false,
            'category_id' => $this->projects->first()->category_id,
        ])->raw();

        $query = Project::whereUserId($this->user->id)
            ->with(['category', 'team'])
            ->withCount('todos');

        $test = Livewire::test(Index::class)
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
        Livewire::test(Index::class)
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

    public function testUserCanSeeOwnedProjectsWithProjectThatHeIsTeamMember()
    {
        $project = Project::factory()->create();
        $project->team()->sync($this->user);

        $this->test = Livewire::test(Index::class);

        $this->assertSame(5, $this->test->get('projects')->count());

        $this->get('/projects')
            ->assertOk()
            ->assertSee($project->name);
    }

    public function testProjectEventWillBeEchoed()
    {
        $project = Project::factory()->create();
        $project->team()->sync($this->user);

        $this->test = Livewire::test(Index::class);

        $this->assertTrue(
            $this->user->can('teamMember', new Project($project->toArray()))
        );

        $this->test
            ->call('echoUpdateProject', [
                'project' => $project->toArray(),
                'userName' => $this->user->name,
            ])
            ->assertEmitted('modal:close')
            ->assertDispatchedBrowserEvent('notify-success');
    }

    private function createProject(array $attrs): Project
    {
        $this->project = Project::create($attrs);

        $this->project->loadMissing(['category', 'team']);
        $this->project->refresh();

        return $this->project;
    }
}