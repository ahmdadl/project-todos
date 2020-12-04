<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class TodoList extends Component
{
    public Category $category;
    public Todo $todo;

    public function remove(): void
    {
        if (!$this->todo->delete()) {
            return;
        }

        $this->emit("todo:deleted", $this->todo->id);
    }

    public function edit(): void
    {
        $this->emit("editTodo", $this->todo);
    }

    public function check(): void
    {
        $this->todo->completed = !$this->todo->completed;
        
        $this->todo->update();
    }

    public function render()
    {
        return view("livewire.todo-list");
    }
}
