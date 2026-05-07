<?php

namespace App\Livewire\AdminDemo;

use App\Models\Category;
use Livewire\Component;

class CategoryDemo extends Component
{
    public $search = '';
    public $category_name, $category_id;
    public $isEdit = false;

    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where('category', 'like', "%{$this->search}%");
            })
            ->latest()
            ->get();

        return view('livewire.admin-demo.category-demo', [
            'categories' => $categories,
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput()
    {
        $this->category_name = '';
        $this->category_id = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate(['category_name' => 'required|string|max:255']);
        Category::create(['category' => $this->category_name]);
        session()->flash('message', 'Category successfully created.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'category-modal');
    }

    public function edit($id)
    {
        $c = Category::findOrFail($id);
        $this->category_id = $id;
        $this->category_name = $c->category;
        $this->isEdit = true;
        $this->dispatch('open-modal', name: 'category-modal');
    }

    public function update()
    {
        $this->validate(['category_name' => 'required|string|max:255']);
        Category::findOrFail($this->category_id)->update(['category' => $this->category_name]);
        session()->flash('message', 'Category successfully updated.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'category-modal');
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('message', 'Category successfully deleted.');
    }
}
