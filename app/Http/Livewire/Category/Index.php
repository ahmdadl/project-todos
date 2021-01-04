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
        'add' => 'append',
        'update' => 'edit',
        'delete' => 'remove',
    ];

    public function mount()
    {
        $this->user = auth()->user();
        $this->categories = Category::withCount('projects')->get();
    }

    public function append(Category $category): void
    {
        $this->categories->push($category);
    }

    public function edit(Category $category): void
    {
        $this->categories->each(function (Category $cat) use ($category) {
            if ($cat->id === $category->id) {
                $cat = $category;
            }
            return $cat;
        });
    }

    public function remove(string $slug)
    {
        $this->categories = $this->categories->filter(
            fn(Category $category) => $category->slug !== $slug
        );
    }

    public function render()
    {
        return view('livewire.category.index');
    }
}
