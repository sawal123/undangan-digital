<?php

namespace App\Livewire\AdminDemo;

use App\Models\Fonts as ModelsFonts;
use Livewire\Component;
use Livewire\WithPagination;

class FontsDemo extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $font_id = null;

    public string $nama = '';

    public string $link = '';

    public bool $is_active = true;

    public bool $isEdit = false;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $fonts = ModelsFonts::query()
            ->when(!empty(trim($this->search)), function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($sub) use ($searchTerm) {
                    $sub->where('nama', 'like', $searchTerm)
                        ->orWhere('link', 'like', $searchTerm);
                });
            })
            ->latest('id')
            ->paginate(10);

        return view('livewire.admin-demo.fonts-demo', [
            'fonts' => $fonts,
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput(): void
    {
        $this->nama = '';
        $this->link = '';
        $this->is_active = true;
        $this->font_id = null;
        $this->isEdit = false;
        $this->resetValidation();
    }

    public function store(): void
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|url|max:500',
            'is_active' => 'boolean',
        ]);

        ModelsFonts::create([
            'nama' => trim($this->nama),
            'link' => trim($this->link),
            'is_active' => (bool) $this->is_active,
        ]);

        session()->flash('message', 'Font berhasil ditambahkan.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'font-modal');
    }

    public function edit(int $id): void
    {
        $font = ModelsFonts::findOrFail($id);
        $this->font_id = $font->id;
        $this->nama = $font->nama;
        $this->link = $font->link;
        $this->is_active = (bool) $font->is_active;
        $this->isEdit = true;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'font-modal');
    }

    public function update(): void
    {
        if (!$this->font_id) {
            return;
        }

        $this->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|url|max:500',
            'is_active' => 'boolean',
        ]);

        $font = ModelsFonts::findOrFail($this->font_id);
        $font->update([
            'nama' => trim($this->nama),
            'link' => trim($this->link),
            'is_active' => (bool) $this->is_active,
        ]);

        session()->flash('message', 'Font berhasil diperbarui.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'font-modal');
    }

    public function delete(int $id): void
    {
        ModelsFonts::findOrFail($id)->delete();
        session()->flash('message', 'Font berhasil dihapus.');
    }
}
