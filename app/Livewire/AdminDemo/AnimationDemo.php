<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\Animation;
use Livewire\Component;
use Livewire\WithFileUploads;

class AnimationDemo extends Component
{
    use WithFileUploads;

    public $search = '';
    public $nama, $link, $thumbnail, $animation_id;
    public $isEdit = false;

    public function render()
    {
        $animations = Animation::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', "%{$this->search}%");
            })
            ->latest()
            ->get();

        return view('livewire.admin-demo.animation-demo', [
            'animations' => $animations,
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput()
    {
        $this->nama = '';
        $this->link = '';
        $this->thumbnail = null;
        $this->animation_id = null;
        $this->isEdit = false;
    }

    private function convertYoutube($link)
    {
        if (strpos($link, 'youtube.com/shorts/') !== false) {
            $parts = explode('shorts/', $link);
            $videoId = end($parts);
            return "https://www.youtube.com/embed/" . $videoId;
        } elseif (strpos($link, 'watch?v=') !== false) {
            $parts = explode('v=', $link);
            $videoId = end($parts);
            return "https://www.youtube.com/embed/" . $videoId;
        }
        return $link;
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|url',
            'thumbnail' => 'nullable|string|max:255', // The original app uses a string for thumbnail here?
        ]);

        Animation::create([
            'nama' => $this->nama,
            'link' => $this->convertYoutube($this->link),
            'thumbnail' => $this->thumbnail
        ]);

        session()->flash('message', 'Animation successfully created.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'animation-modal');
    }

    public function edit($id)
    {
        $animation = Animation::findOrFail($id);
        $this->animation_id = $id;
        $this->nama = $animation->nama;
        $this->link = $animation->link;
        $this->thumbnail = $animation->thumbnail;
        $this->isEdit = true;
        $this->dispatch('open-modal', name: 'animation-modal');
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required|url',
        ]);

        $animation = Animation::findOrFail($this->animation_id);
        $animation->update([
            'nama' => $this->nama,
            'link' => $this->convertYoutube($this->link),
            'thumbnail' => $this->thumbnail
        ]);

        session()->flash('message', 'Animation successfully updated.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'animation-modal');
    }

    public function delete($id)
    {
        Animation::findOrFail($id)->delete();
        session()->flash('message', 'Animation successfully deleted.');
    }
}
