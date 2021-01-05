<?php

namespace App\Http\Livewire\Todo;

use App\Events\TodoDeleted;
use App\Models\Project;
use App\Models\Todo;
use App\Traits\HasToastNotify;
use Livewire\Component;

class One extends Component
{
    use HasToastNotify;

    public Project $project;
    public Todo $todo;

    public function remove(): void
    {
        if (!$this->todo->delete()) {
            return;
        }

        $this->emit('todo:deleted', $this->todo->id);
        $this->success('Deleted Successfully');
        TodoDeleted::dispatch(
            $this->todo->id,
            $this->todo->project_id,
            $this->todo->body,
            auth()->user()->name
        );
    }

    public function edit(): void
    {
        $this->emit('editTodo', $this->todo->id);
    }

    public function check(): void
    {
        $this->todo->completed = !$this->todo->completed;

        $this->todo->update();
    }

    public function render()
    {
        return view('livewire.todo.one');
    }
}
