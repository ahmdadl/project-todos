<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use App\Models\User;
use App\Traits\HasToastNotify;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Create extends Component
{
    use HasToastNotify;

    public User $user;
    public ?Category $category = null;
    public string $title = '';
    public bool $editMode = false;

    protected $rules = [
        'title' => 'required|string|min:5',
    ];

    protected $listeners = [
        'edit' => 'edit'
    ];

    public function mount()
    {
        abort_unless(auth()->check() && Gate::allows('is_admin'), 403);

        $this->user = auth()->user();
    }

    public function edit(Category $category)
    {
        $this->title = $category->title;
        $this->category = $category;
        $this->editMode = true;
    }

    public function submit()
    {
        $this->validate();

        if ($this->editMode) {
            $this->update();
            return;
        }

        $this->save();

        $this->resetProps();
    }

    private function save()
    {
        $category = Category::create([
            'title' => $this->title,
        ]);

        $this->success('Category Created Successfully');

        $this->emit(
            'add-category',
            $category->slug
        );
    }

    private function update()
    {

    }

    public function resetProps()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset('title', 'category');
    }

    public function render()
    {
        return view('livewire.category.create');
    }
}
