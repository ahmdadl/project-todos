<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Todo;
use App\Traits\HasToastNotify;
use Arr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Str;

class GetTodoList extends Component
{
    use AuthorizesRequests;
    use HasToastNotify;

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
            "echo-private:todos.{$this->project->id},TodoCreated" => 'echoAppendTodo',
            "echo-private:todos.{$this->project->id},TodoUpdated" => 'echoUpdateTodo',
            "echo-private:todos.{$this->project->id},TodoDeleted" => 'echoRemoveTodo',
        ];
    }

    public function appendTodo($todo)
    {
        if (is_int($todo)) {
            $todo = Todo::find($todo);
        }

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

    public function echoAppendTodo(array $ev)
    {
        $this->appendTodo($ev['todo']['id']);
        $this->success('New Todo Added by (' . $ev['userName'] . ')');
    }

    public function echoUpdateTodo(array $ev)
    {
        $todo = (object) $ev['todo'];
        $this->updateTodoList($todo->id, $todo->body, $todo->completed);
        $this->success(
            'Todo (' . Str::limit($todo->body, 35) . ') Updated by (' . $ev['userName'] . ')'
        );
    }

    public function echoRemoveTodo(array $todo)
    {
        $this->removeFromTodoList($todo['id']);
        $this->success(
            'Todo (' .
                Str::limit($todo['body'], 35) .
                ') Deleted by (' .
                $todo['userName'] .
                ')'
        );
    }

    public function render()
    {
        return view('livewire.get-todo-list');
    }
}
