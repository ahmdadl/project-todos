<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class GetTodoList extends Component
{
    protected $listeners = [
        "todo:saved" => "appendTodo",
        "todo:updated" => "updateTodoList",
        "todo:deleted" => "removeFromTodoList",
    ];

    public Collection $todos;
    public Category $category;

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->todos = Todo::whereCategoryId($category->id)
            ->whereUserId(auth()->id())
            ->latest()
            ->get();
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
        return view("livewire.get-todo-list", ["header" => "sadsad"]);
    }
}
