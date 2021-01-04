<?php

namespace App\Http\Livewire\Category;

use App\Models\Category;
use App\Traits\HasToastNotify;
use Livewire\Component;

class One extends Component
{
    use HasToastNotify;

    public Category $category;

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function destroy()
    {
        if (!$this->category->delete()) {
            return;
        }    

        $this->success('Category Deleted Successfully');

        $this->emit('delete', $this->category->slug);
    }

    public function render()
    {
        return view('livewire.category.one');
    }
}
