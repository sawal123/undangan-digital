<?php

namespace App\Livewire\AdminDemo;

use App\Models\Category;
use App\Models\Theme;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryDemo extends Component
{
    use WithPagination;

    public string $search = '';

    public string $category_name = '';

    public ?int $category_id = null;

    public bool $isEdit = false;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::query()
            ->when(!empty(trim($this->search)), function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($sub) use ($searchTerm) {
                    $sub->where('category', 'like', $searchTerm);
                });
            })
            ->latest('id')
            ->paginate(10);

        return view('livewire.admin-demo.category-demo', [
            'categories' => $categories,
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput(): void
    {
        $this->category_name = '';
        $this->category_id = null;
        $this->isEdit = false;
        $this->resetValidation();
    }

    public function create(): void
    {
        $this->resetInput();
        $this->dispatch('open-modal', name: 'category-modal');
    }

    public function store(): void
    {
        $this->validate([
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category'),
            ],
        ], [
            'category_name.required' => 'Nama kategori wajib diisi.',
            'category_name.unique' => 'Nama kategori sudah ada.',
        ]);

        Category::create(['category' => trim($this->category_name)]);

        session()->flash('message', 'Kategori berhasil dibuat.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'category-modal');
    }

    public function edit(int $id): void
    {
        $c = Category::findOrFail($id);
        $this->category_id = $c->id;
        $this->category_name = $c->category;
        $this->isEdit = true;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'category-modal');
    }

    public function update(): void
    {
        if (!$this->category_id) {
            return;
        }

        $this->validate([
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'category')->ignore($this->category_id),
            ],
        ], [
            'category_name.required' => 'Nama kategori wajib diisi.',
            'category_name.unique' => 'Nama kategori sudah ada.',
        ]);

        Category::findOrFail($this->category_id)->update(['category' => trim($this->category_name)]);

        session()->flash('message', 'Kategori berhasil diperbarui.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'category-modal');
    }

    public function delete(int $id): void
    {
        $category = Category::findOrFail($id);

        // Relation Check: Prevent deletion if themes exist
        if (Theme::where('category_id', $category->id)->exists()) {
            session()->flash('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh Tema.');
            return;
        }

        $category->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
    }
}
