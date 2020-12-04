<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Todo;
use Livewire\Component;

class AddTodo extends Component
{
    protected $rules = [
        "body" => "required|string|min:5|max:255",
    ];

    protected $listeners = [
        "editTodo" => "setEditMode",
    ];

    public Category $category;
    public string $body = "";
    public bool $editMode = false;
    public Todo $todo;

    public function mount(Category $category): void
    {
        $this->category = $category;
    }

    public function submit(): void
    {
        if ($this->editMode) {
            $this->update();
            return;
        }
        $this->store();
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
        $this->reset(["body"]);

        $this->dispatchBrowserEvent('edit-mode-off');
    }

    public function render()
    {
        return view("livewire.add-todo");
    }

    private function store(): void
    {
        $this->validate();

        $todo = $this->category->todos()->create([
            "body" => $this->body,
            "user_id" => auth()->id(),
        ]);

        session()->flash("todo_saved", "Todo Successfully Saved");

        $this->emitUp("todo:saved", $todo->id);

        $this->clearValidation();
        $this->body = "";
    }

    private function update(): void
    {
        $this->validate();

        $this->todo->body = $this->body;

        if ($this->todo->update()) {
            session()->flash("todo_saved", "todo updated");
        }

        $this->emit("todo:updated", $this->todo->id, $this->body);

        $this->disableEditMode();
        $this->clearValidation();
    }
}
