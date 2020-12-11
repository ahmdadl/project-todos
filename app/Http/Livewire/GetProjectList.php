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

    public function mount()
    {
        $this->user = auth()->user();
        $this->allProjects = Project::whereUserId($this->user->id)
            ->with('category')
            ->latest()
            ->get();
        $this->projects = $this->allProjects;
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

    public function render()
    {
        return view('livewire.get-project-list');
    }
}
