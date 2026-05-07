<?php

namespace App\Livewire\AdminDemo;

use App\Models\Fonts as ModelsFonts;
use Livewire\Component;
use Livewire\WithPagination;

class FontsDemo extends Component
{
    use WithPagination;

    public $search = '';
    public $font_id, $nama, $link, $is_active = true;
    public $isEdit = false;

    public function render()
    {
        $fonts = ModelsFonts::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', "%{$this->search}%")
                    ->orWhere('link', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin-demo.fonts-demo', [
            'fonts' => $fonts,
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput()
    {
        $this->nama = '';
        $this->link = '';
        $this->is_active = true;
        $this->font_id = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);

        ModelsFonts::create([
            'nama' => $this->nama,
            'link' => $this->link,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Font successfully created.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'font-modal');
    }

    public function edit($id)
    {
        $font = ModelsFonts::findOrFail($id);
        $this->font_id = $id;
        $this->nama = $font->nama;
        $this->link = $font->link;
        $this->is_active = $font->is_active;
        $this->isEdit = true;
        $this->dispatch('open-modal', name: 'font-modal');
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);

        $font = ModelsFonts::findOrFail($this->font_id);
        $font->update([
            'nama' => $this->nama,
            'link' => $this->link,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Font successfully updated.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'font-modal');
    }

    public function delete($id)
    {
        ModelsFonts::findOrFail($id)->delete();
        session()->flash('message', 'Font successfully deleted.');
    }
}
