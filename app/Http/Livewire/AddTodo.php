<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Todo;
use Livewire\Component;

class AddTodo extends Component
{
    protected $rules = [
        'body' => 'required|string|min:5|max:255',
    ];

    public Category $category;
    public string $body;

    public function mount(Category $category):void
    {
        $this->category = $category;
    }

    public function store(): void
    {
        $this->validate();

        $this->category->todos()->create([
            'body' => $this->body,
            'user_id' => auth()->id()
        ]);

        session()->flash('message', 'Todo Seccessfully Saved');

        $this->emit('todo:saved');
    }

    public function render()
    {
        return view('livewire.add-todo');
    }
}
