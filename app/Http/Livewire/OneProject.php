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
    public bool $openModal = false;

    public function toggleModal()
    {
        $this->openModal = !$this->openModal;
    }

    public function edit()
    {
        $this->emit(
            'project:edit',
            $this->project->slug,
            $this->project->category->slug
        );
    }

    public function destroy()
    {
        $this->project->delete();

        $this->emit('project:deleted', $this->project->slug);
    }

    public function toggleCompleted()
    {
        $this->project->completed = !$this->project->completed;
        $this->project->update();
    }

    public function render()
    {
        return view('livewire.one-project');
    }
}
