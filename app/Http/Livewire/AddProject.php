<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;
use Str;

class AddProject extends Component
{
    use WithFileUploads;

    public User $user;
    public Collection $categories;

    public string $title = '';
    public string $categorySlug = '';
    public string $cost = '';
    public $image;
    public bool $completed = false;
    public bool $showModal = false;

    protected $listeners = [
        'modal:close' => 'resetProps',
    ];

    protected $rules = [
        'title' => 'required|string|min:5|max:255',
        'categorySlug' => 'required|string|exists:categories,slug',
        'cost' => 'required|numeric|regex:/[0-9]+(\.[0-9]{1,2})?%?/',
        'image' => 'required|image|max:1024',
        'completed' => 'sometimes|required|boolean',
    ];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function save()
    {
        $this->validate();

        $img = $this->image->store('public/projects');
        $img = Str::replaceFirst('public/', '', $img);

        $category = Category::whereSlug($this->categorySlug)->first();

        $project = $category->projects()->create([
            'user_id' => auth()->id(),
            'name' => $this->title,
            'cost' => (float) $this->cost,
            'image' => $img,
            'completed' => (bool) $this->completed,
        ]);

        $this->emit('project:added', $project->slug);
        $this->dispatchBrowserEvent('reset-img', $project->slug);
    }

    public function resetProps()
    {
        $this->resetValidation();
        $this->resetErrorBag();
        $this->reset(['categorySlug', 'title', 'cost', 'image', 'completed']);

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.add-project');
    }
}
