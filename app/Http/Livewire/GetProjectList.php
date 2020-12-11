<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class GetProjectList extends Component
{
    public Collection $projects;
    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
        $this->projects = Project::whereUserId($this->user->id)
            ->with('category')
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.get-project-list');
    }
}
