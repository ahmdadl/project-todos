<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Todo;
use App\Traits\HasToastNotify;
use Livewire\Component;

class AddTodo extends Component
{
    use HasToastNotify;

    protected $rules = [
        'body' => 'required|string|min:5|max:255',
    ];

    protected $listeners = [
        'editTodo' => 'setEditMode',
    ];

    public Project $project;
    public string $body = '';
    public bool $editMode = false;
    public Todo $todo;

    public function mount(Project $project): void
    {
        $this->project = $project;
    }

    public function submit(): void
    {
        if ($this->editMode) {
            $this->update();
            return;
        }
        $this->store();

        $this->resetProps();
    }

    public function setEditMode(Todo $todo): void
    {
        $this->editMode = true;
        $this->body = $todo->body;
        $this->todo = $todo;

        $this->dispatchBrowserEvent('edit-mode', $todo->body);
    }

    public function disableEditMode(): void
    {
        $this->editMode = false;
        $this->reset(['body']);

        $this->dispatchBrowserEvent('edit-mode-off');
    }

    public function render()
    {
        return view('livewire.add-todo');
    }

    public function store(): void
    {
        $this->validate();

        $todo = $this->project->todos()->create([
            'body' => $this->body,
        ]);

        $this->success('Todo Saved Successfully');

        $this->emitUp('todo:saved', $todo->id);
    }

    private function update(): void
    {
        $this->validate();

        $this->todo->body = $this->body;

        if (!$this->todo->update()) {
            return;
        }

        $this->success('Todo Updated Successfully');

        $this->emit(
            'todo:updated',
            $this->todo->id,
            $this->body,
            $this->todo->completed
        );

        $this->disableEditMode();
        $this->clearValidation();
        $this->reset(['body']);
    }

    private function resetProps()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['body']);
        $this->dispatchBrowserEvent('edit-mode-off');
    }
}
