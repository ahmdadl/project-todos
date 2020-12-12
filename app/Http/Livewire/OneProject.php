<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class OneProject extends Component
{
    public User $user;
    public Project $project;

    public function render()
    {
        return view('livewire.one-project');
    }
}
