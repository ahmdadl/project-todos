<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class GetProjectList extends Component
{
    public Collection $allProjects;
    public Collection $projects;
    public User $user;
    public bool $onlyCompleted = false;
    public string $sortBy = '';
    public bool $showModal = false;

    protected $listeners = [
        'modal:closed' => 'closeModal',
        'project:added' => 'appendProject',
        'project:updated' => 'updateProject',
        'project:deleted' => 'removeProject',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->getData('asc', false);
    }

    public function showOnlyCompleted(
        bool $toggle = true,
        ?Collection $collection = null
    ) {
        if ($toggle) {
            $this->onlyCompleted = !$this->onlyCompleted;
        }

        $collection = $collection ?? $this->allProjects;

        if ($this->onlyCompleted) {
            $projects = $this->allProjects->filter(
                fn(Project $p) => $p->completed === $this->onlyCompleted
            );

            $this->projects = $this->applySort($projects);

            return;
        }

        $this->projects = $this->applySort($this->allProjects);
    }

    public function appendProject(Project $project)
    {
        $this->allProjects->prepend($project);

        $this->applyFilters();

        $this->emit('modal:close');
    }

    public function updateProject(Project $project)
    {
        $this->allProjects->each(function (Project $p) use ($project) {
            if ($project->slug === $p->slug) {
                $p->name = $project->name;
                $p->cost = $project->cost;
                $p->completed = $project->completed;
            }
        });

        $this->applyFilters();

        $this->emit('modal:close');
    }

    public function removeProject(string $slug)
    {
        $this->allProjects
            ->each(fn($p) => $p->slug === $slug ? null : $p)
            ->values();

        $this->projects
            ->each(fn($p) => $p->slug === $slug ? null : $p)
            ->values();
    }

    public function sortByHighCost()
    {
        $this->getData('desc');
    }

    public function sortByLowCost()
    {
        $this->getData('asc');
    }

    public function resetSortBy(): void
    {
        $this->getData('asc', false);
    }

    public function render()
    {
        return view('livewire.get-project-list');
    }

    private function getData(string $sortBy = 'asc', bool $sort = true): void
    {
        if ($this->sortBy === $sortBy && $sort) {
            return;
        }

        $query = Project::whereUserId($this->user->id)
            ->with(['category', 'team'])
            ->withCount('todos');

        if ($sort) {
            $query->orderBy('cost', $sortBy);
            $this->sortBy = $sortBy;
        } else {
            $this->sortBy = '';
            $query->latest();
        }

        // check for completed filter
        if ($this->onlyCompleted) {
            $query->whereCompleted(true);
        }

        $this->allProjects = $query->get();

        $teamProjects = $this->user->load('team_projects')
            ->team_projects;

        $this->allProjects = $this->allProjects->merge($teamProjects);

        $this->projects = $this->allProjects;
    }

    private function applySort(Collection $collection): Collection
    {
        $projects = $collection;

        if (!empty($this->sortBy)) {
            $projects =
                $this->sortBy === 'asc'
                    ? $projects->sortBy('cost')
                    : $projects->sortByDesc('cost');
        }

        return $projects;
    }

    private function applyFilters(): void
    {
        $projects = $this->applySort($this->allProjects);

        $this->showOnlyCompleted(false, $projects);
    }
}
