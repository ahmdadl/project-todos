<?php

namespace Tests\Feature;

use App\Http\Livewire\GetProjectList;
use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire;
use Tests\TestCase;

class GetProjectListTest extends TestCase
{
    use RefreshDatabase;

    public function testItWillPrependProjectAndApplyFilters()
    {
        $user = User::factory()->create();

        $projects = Project::factory()
            ->count(4)
            ->for(Category::factory())
            ->sequence(['user_id' => $user->id])
            ->create();

        $project = Project::factory()->raw([
            'user_id' => $user->id,
        ]);

        $this->signIn($user);

        $query = Project::whereUserId($user->id)
            ->with(['category', 'team'])
            ->latest();

        Livewire::test(GetProjectList::class)
            ->assertSee('add new project')
            ->assertSet('allProjects', $query->get())
            ->call('sortByHighCost')
            ->assertSet('allProjects', $query->orderByDesc('cost')->get())
            ->call('appendProject', Project::create($project)->slug)
            ->assertSet('allProjects', $query->orderByDesc('cost')->get())
            ->call('showOnlyCompleted')
            // only projects collection should contain only
            // completed projects
            ->assertNotSet(
                'allProjects',
                $query
                    ->whereCompleted(true)
                    ->orderByDesc('cost')
                    ->get()
            )
            ->assertSet(
                'projects',
                $query
                    ->whereCompleted(true)
                    ->orderByDesc('cost')
                    ->get()
            );
    }
}
