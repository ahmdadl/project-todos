<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Index extends Component
{
    public Collection $categories;
    public User $user;

    protected $listeners = [
        'add-category' => 'appendCategory',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->categories = Category::withCount("projects")->get();
    }

    public function appendCategory(Category $category): void
    {
        $this->categories->push($category);
    }

    public function render()
    {
        return view('livewire.category.index');
    }
}
