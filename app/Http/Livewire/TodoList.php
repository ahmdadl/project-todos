<?php

namespace App\Http\Livewire;

use App\Events\TodoDeleted;
use App\Models\Project;
use App\Models\Todo;
use Livewire\Component;

class TodoList extends Component
{
    public Project $project;
    public Todo $todo;

    public function remove(): void
    {
        if (!$this->todo->delete()) {
            return;
        }

        $this->emit('todo:deleted', $this->todo->id);
        TodoDeleted::dispatch($this->todo->id, $this->todo->project_id);
    }

    public function edit(): void
    {
        $this->emit('editTodo', $this->todo);
    }

    public function check(): void
    {
        $this->todo->completed = !$this->todo->completed;

        $this->todo->update();
    }

    public function render()
    {
        return view('livewire.todo-list');
    }
}
