<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
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
        'project:deleted' => 'removeProject',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->getData('asc', false);
    }

    public function showOnlyCompleted(bool $toggle = true)
    {
        if ($toggle) {
            $this->onlyCompleted = !$this->onlyCompleted;
        }

        if ($this->onlyCompleted) {
            $this->projects = $this->allProjects->filter(
                fn(Project $p) => $p->completed === $this->onlyCompleted
            );
            return;
        }

        $this->projects = $this->allProjects;
    }

    public function appendProject(Project $project)
    {
        $projects = $this->allProjects;

        $projects->prepend($project);

        if (!empty($this->sortBy)) {
            $projects =
                $this->sortBy === 'asc'
                    ? $projects->sortBy('cost')
                    : $projects->sortByDesc('cost');
        }

        $this->allProjects = $projects;

        if ($this->onlyCompleted) {
            $this->showOnlyCompleted(false);
        } else {
            $this->projects = $this->allProjects;
        }

        $this->emit('modal:close');
    }

    public function removeProject(int $index)
    {
        $this->allProjects->splice($index, 1);
        $this->projects->splice($index, 1);
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

        $this->allProjects = $query->get();
        $this->projects = $this->allProjects;
    }
}
