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
use Tests\TestCase;

class GetProjectListTest extends TestCase
{
    use RefreshDatabase;

    public Project $project;

    public function testItWillPrependProjectAndApplyFilters()
    {
        $user = User::factory()->create();

        $projects = Project::factory()
            ->count(4)
            ->for(Category::factory())
            ->sequence(['user_id' => $user->id])
            ->create();

        $project = Project::factory([
            'user_id' => $user->id,
            'cost' => 556.32,
            'completed' => 1,
            'category_id' => $projects->first()->category_id,
        ])->raw();

        $this->signIn($user);

        $query = Project::whereUserId($user->id)
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

    private function createProject(array $attrs): Project
    {
        $this->project = Project::create($attrs);

        $this->project->loadMissing(['category', 'team']);
        $this->project->refresh();

        return $this->project;
    }

    private function projectCreated(Collection $collection)
    {
        dump($collection->pluck('cost', 'id'));
        return $collection;
    }
}
