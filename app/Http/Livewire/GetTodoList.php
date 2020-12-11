<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class GetTodoList extends Component
{
    public Collection $todos;
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->todos = Todo::whereProjectId($project->id)
            ->latest()
            ->get();
    }

    public function getListeners()
    {
        return [
            'todo:saved' => 'appendTodo',
            'todo:updated' => 'updateTodoList',
            'todo:deleted' => 'removeFromTodoList',
            "echo-private:todos.{$this->project->id},TodoAdded" => 'appendTodo',
        ];
    }

    public function appendTodo(Todo $todo)
    {
        $this->todos->prepend($todo);
    }

    public function updateTodoList(int $id, string $body)
    {
        $this->todos->each(function (Todo $todo) use ($id, $body) {
            if ($todo->id === $id) {
                $todo->body = $body;
            }
        });
    }

    public function removeFromTodoList(int $id): void
    {
        $this->todos = $this->todos->filter(
            fn(Todo $todo) => $todo->id !== $id
        );
    }

    public function render()
    {
        return view('livewire.get-todo-list');
    }
}
