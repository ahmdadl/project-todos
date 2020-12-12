<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class AddProject extends Component
{
    public User $user;
    public Collection $categories;

    public string $title = '';
    public string $categorySlug = '';
    public string $cost = '';
    public bool $completed = false;

    protected $listeners = [
        'modal:close' => 'resetProps',
    ];

    protected $rules = [
        'title' => 'required|string|min:5|max:255',
        'categorySlug' => 'required|string|exists:categories,slug',
        'cost' => 'required|numeric|regex:/[0-9]+(\.[0-9]{1,2})?%?/',
        'completed' => 'sometimes|required|boolean',
    ];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function save()
    {
        $this->validate();

        $category = Category::whereSlug($this->categorySlug)->first();

        $project = $category->projects()->create([
            'user_id' => auth()->id(),
            'name' => $this->title,
            'cost' => (float) $this->cost,
            'completed' => (bool) $this->completed,
        ]);

        $this->emit('project:added', $project->slug);

        $this->resetProps();
    }

    public function resetProps()
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->reset(['categorySlug', 'title', 'cost', 'completed']);

        $this->emit('modal:closed');
    }

    public function render()
    {
        return view('livewire.add-project');
    }
}
