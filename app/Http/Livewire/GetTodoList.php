<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class GetTodoList extends Component
{
    use AuthorizesRequests;

    public Collection $todos;
    public Project $project;

    public function mount(Project $project)
    {
        $this->authorize('teamMember', $project);

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
            "echo-private:todos.{$this->project->id},TodoCreated" => 'appendTodo',
            "echo-private:todos.{$this->project->id},TodoUpdated" => 'echoUpdateTodo',
            "echo-private:todos.{$this->project->id},TodoDeleted" => 'echoRemoveTodo',
        ];
    }

    public function appendTodo(Todo $todo)
    {
        $this->todos->prepend($todo);
    }

    public function updateTodoList(int $todoId, string $body, bool $completed)
    {
        $this->todos->each(function (Todo $t) use ($todoId, $body, $completed) {
            if ($t->id === $todoId) {
                $t->body = $body;
                $t->completed = $completed;
            }
        });
    }

    public function removeFromTodoList(int $id): void
    {
        $this->todos = $this->todos->filter(
            fn(Todo $todo) => $todo->id !== $id
        );
    }

    public function echoUpdateTodo(Todo $todo)
    {
        $this->updateTodoList($todo->id, $todo->body, $todo->completed);
    }

    public function echoRemoveTodo(array $todo)
    {
        $this->removeFromTodoList($todo['id']);
    }

    public function render()
    {
        return view('livewire.get-todo-list');
    }
}
