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

    public function mount()
    {
        $this->user = auth()->user();
        $this->getData('asc', false);
    }

    public function showOnlyCompleted()
    {
        $this->onlyCompleted = !$this->onlyCompleted;

        if ($this->onlyCompleted) {
            $this->projects = $this->allProjects->filter(
                fn(Project $p) => $p->completed === $this->onlyCompleted
            );
            return;
        }

        $this->projects = $this->allProjects;
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
        if ($this->sortBy === $sortBy) {
            return;
        }

        $query = Project::whereUserId($this->user->id)->with('category');

        if ($sort) {
            $query->orderBy('cost', $sortBy);
            $this->sortBy = $sortBy;
        } else {
            $this->sortBy = '';
        }

        $this->allProjects = $query->latest()->get();
        $this->projects = $this->allProjects;
    }
}
