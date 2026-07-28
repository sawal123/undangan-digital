<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\Animation;
use Livewire\Component;
use Livewire\WithPagination;

class AnimationDemo extends Component
{
    use WithPagination;

    public string $search = '';

    public string $nama = '';

    public string $link = '';

    public ?string $thumbnail = null;

    public ?int $animation_id = null;

    public bool $isEdit = false;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $animations = Animation::query()
            ->when(!empty(trim($this->search)), function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($sub) use ($searchTerm) {
                    $sub->where('nama', 'like', $searchTerm)
                        ->orWhere('link', 'like', $searchTerm);
                });
            })
            ->latest('id')
            ->paginate(10);

        return view('livewire.admin-demo.animation-demo', [
            'animations' => $animations,
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput(): void
    {
        $this->nama = '';
        $this->link = '';
        $this->thumbnail = null;
        $this->animation_id = null;
        $this->isEdit = false;
        $this->resetValidation();
    }

    private function convertYoutube(string $link): string
    {
        $link = trim($link);
        if (preg_match('/(?:youtube\.com\/(?:watch\?.*v=|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $link, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return $link;
    }

    public function store(): void
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|url',
            'thumbnail' => 'nullable|string|max:500',
        ]);

        Animation::create([
            'nama' => $this->nama,
            'link' => $this->convertYoutube($this->link),
            'thumbnail' => $this->thumbnail,
        ]);

        session()->flash('message', 'Animasi berhasil ditambahkan.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'animation-modal');
    }

    public function edit(int $id): void
    {
        $animation = Animation::findOrFail($id);
        $this->animation_id = $animation->id;
        $this->nama = $animation->nama;
        $this->link = $animation->link;
        $this->thumbnail = $animation->thumbnail;
        $this->isEdit = true;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'animation-modal');
    }

    public function update(): void
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|url',
            'thumbnail' => 'nullable|string|max:500',
        ]);

        if (!$this->animation_id) {
            return;
        }

        $animation = Animation::findOrFail($this->animation_id);
        $animation->update([
            'nama' => $this->nama,
            'link' => $this->convertYoutube($this->link),
            'thumbnail' => $this->thumbnail,
        ]);

        session()->flash('message', 'Animasi berhasil diperbarui.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'animation-modal');
    }

    public function delete(int $id): void
    {
        Animation::findOrFail($id)->delete();
        session()->flash('message', 'Animasi berhasil dihapus.');
    }
}
