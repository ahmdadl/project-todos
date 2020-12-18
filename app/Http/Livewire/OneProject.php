<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class OneProject extends Component
{
    public User $user;
    public Project $project;
    public int $index;

    public function edit()
    {
        $this->emit(
            'project:edit',
            $this->project->slug,
            $this->project->category->slug
        );
    }

    public function destroy(int $index)
    {
        $this->project->delete();

        $this->emit('project:deleted', $index);
    }

    public function render()
    {
        return view('livewire.one-project');
    }
}
