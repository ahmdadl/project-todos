<?php

namespace App\Http\Livewire;

use App\Events\ProjectDeleted;
use App\Models\Project;
use App\Models\User;
use App\Traits\HasToastNotify;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Str;

class OneProject extends Component
{
    use AuthorizesRequests;
    use HasToastNotify;

    public User $user;
    public Project $project;
    public int $index;
    public bool $openModal = false;
    public bool $teamModal = false;
    public string $teamUserMail = '';

    protected $rules = [
        'teamUserMail' => 'required|email|exists:users,email',
    ];

    protected $validationAttributes = [
        'teamUserMail' => 'User Email Address',
    ];

    public function toggleModal()
    {
        $this->openModal = !$this->openModal;
    }

    public function toggleTeamModal(): void
    {
        $this->resetTeamModal();

        $this->teamModal = !$this->teamModal;
    }

    public function edit()
    {
        $this->authorize('teamMember', $this->project);

        $this->emit(
            'project:edit',
            $this->project->slug,
            $this->project->category->slug
        );
    }

    public function destroy()
    {
        $this->authorize('owner', $this->project);

        $this->project->delete();

        $this->success('Project Deleted Successfully');

        ProjectDeleted::dispatch($this->project->name, $this->project->slug);

        $this->emit('project:deleted', $this->project->slug);
    }

    public function toggleCompleted()
    {
        $this->authorize('teamMember', $this->project);

        $this->project->completed = !$this->project->completed;
        $this->project->update();

        $this->success('Project Updated Successfully');
    }

    public function addUserToTeam()
    {
        $this->authorize('owner', $this->project);

        $this->validate();

        $user = User::whereEmail($this->teamUserMail)->first('id');

        $this->project->team()->syncWithoutDetaching($user->id);
        $this->project->load('team');

        $this->success(
            'User (' .
                Str::limit($this->teamUserMail, 10) .
                ') Added To Team Successfully'
        );

        $this->toggleTeamModal();
    }

    private function resetTeamModal()
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->reset(['teamUserMail']);
    }

    public function render()
    {
        return view('livewire.one-project');
    }
}
