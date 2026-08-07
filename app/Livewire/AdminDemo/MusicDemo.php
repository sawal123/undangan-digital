<?php

namespace App\Livewire\AdminDemo;

use App\Models\Music;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class MusicDemo extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $music_id = null;

    public string $judul = '';

    public string $link = '';

    public string $artis = '';

    public ?int $category_id = null;

    public bool $isEdit = false;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $music = Music::query()
            ->with('category')
            ->when(!empty(trim($this->search)), function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($sub) use ($searchTerm) {
                    $sub->where('judul', 'like', $searchTerm)
                        ->orWhere('artis', 'like', $searchTerm)
                        ->orWhereHas('category', function ($q) use ($searchTerm) {
                            $q->where('category', 'like', $searchTerm);
                        });
                });
            })
            ->latest('id')
            ->paginate(10);

        $categories = Category::orderBy('category')->get();

        return view('livewire.admin-demo.music-demo', [
            'music' => $music,
            'categories' => $categories,
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput(): void
    {
        $this->judul = '';
        $this->link = '';
        $this->artis = '';
        $this->category_id = null;
        $this->music_id = null;
        $this->isEdit = false;
        $this->resetValidation();
    }

    /**
     * Convert YouTube URL ke format embed.
     * Mendukung: youtube.com/watch?v=, youtu.be/, youtube.com/embed/
     */
    protected function convertToEmbedUrl(string $url): string
    {
        $url = trim($url);

        // Already embed format — return as-is
        if (str_contains($url, 'youtube.com/embed/') || str_contains($url, 'www.youtube.com/embed/')) {
            return $url;
        }

        $videoId = null;

        // youtube.com/watch?v=VIDEO_ID
        if (preg_match('/[?&]v=([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // youtu.be/VIDEO_ID
        elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            return 'https://www.youtube.com/embed/' . $videoId;
        }

        // Not a recognizable YouTube URL — return original
        return $url;
    }

    public function store(): void
    {
        $this->validate([
            'judul' => 'required|string|max:255',
            'link' => 'required|url|max:500',
            'artis' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        Music::create([
            'judul' => trim($this->judul),
            'link' => $this->convertToEmbedUrl($this->link),
            'artis' => trim($this->artis),
            'category_id' => $this->category_id,
        ]);

        session()->flash('message', 'Musik berhasil ditambahkan.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'music-modal');
    }

    public function edit(int $id): void
    {
        $music = Music::findOrFail($id);
        $this->music_id = $music->id;
        $this->judul = $music->judul;
        $this->link = $music->link;
        $this->artis = $music->artis;
        $this->category_id = $music->category_id;
        $this->isEdit = true;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'music-modal');
    }

    public function update(): void
    {
        if (!$this->music_id) {
            return;
        }

        $this->validate([
            'judul' => 'required|string|max:255',
            'link' => 'required|url|max:500',
            'artis' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $music = Music::findOrFail($this->music_id);
        $music->update([
            'judul' => trim($this->judul),
            'link' => $this->convertToEmbedUrl($this->link),
            'artis' => trim($this->artis),
            'category_id' => $this->category_id,
        ]);

        session()->flash('message', 'Musik berhasil diperbarui.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'music-modal');
    }

    public function delete(int $id): void
    {
        Music::findOrFail($id)->delete();
        session()->flash('message', 'Musik berhasil dihapus.');
    }
}
