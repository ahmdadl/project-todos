<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Storage;
use Str;

class AddProject extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public User $user;
    public Project $project;
    public Collection $categories;

    public string $name = '';
    public string $categorySlug = '';
    public string $cost = '';
    public $image;
    public bool $completed = false;
    public bool $showModal = false;
    public bool $editMode = false;

    protected $listeners = [
        'modal:close' => 'resetProps',
        'project:edit' => 'editProject',
    ];

    protected $rules = [
        'categorySlug' => 'required|string|exists:categories,slug',
        'name' => 'required|string|min:5|max:255',
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
        $this->resetProps();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function editProject(Project $project, string $categorySlug)
    {
        $this->openModal();

        $this->editMode = true;

        $this->project = $project;

        $this->categorySlug = $categorySlug;
        $this->name = $project->name;
        $this->cost = $project->cost;
        $this->image = null;
        $this->completed = $project->completed;
    }

    public function save()
    {
        if ($this->editMode) {
            $this->rules['image'] = 'nullable|image|max:1024';
            unset($this->rules['categorySlug']);
        }

        $this->validate();

        if ($this->editMode) {
            $this->update();
        } else {
            $this->create();
        }

        $this->dispatchBrowserEvent('reset-img');
    }

    private function create()
    {
        $img = $this->saveImage();

        $category = Category::whereSlug($this->categorySlug)->first();

        $project = $category->projects()->create([
            'user_id' => auth()->id(),
            'name' => $this->name,
            'cost' => (float) $this->cost,
            'image' => $img,
            'completed' => (bool) $this->completed,
        ]);

        $this->emit('project:added', $project->slug);
    }

    private function update()
    {
        $this->authorize('update', $this->project);

        if (isset($this->image)) {
            // upload new image first
            $img = $this->saveImage();

            // delete old image
            Storage::disk('public')->delete($this->project->image);

            // then assign to project instance
            $this->project->image = $img;
        }

        $this->project->name = $this->name;
        $this->project->cost = $this->cost;
        $this->project->completed = $this->completed;

        $this->project->update();

        $this->emit('project:updated', $this->project->slug);
    }

    public function resetProps()
    {
        $this->editMode = false;
        $this->resetValidation();
        $this->resetErrorBag();
        $this->reset(['categorySlug', 'name', 'cost', 'image', 'completed']);

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.add-project');
    }

    private function saveImage(): string
    {
        $img = $this->image->store('projects', 'public');
        return Str::replaceFirst('public/', '', $img);
    }
}
