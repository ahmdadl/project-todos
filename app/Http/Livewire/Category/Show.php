<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use Livewire\Component;

class Show extends Component
{
    public Category $category;

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        return view('livewire.category.show');
    }
}
