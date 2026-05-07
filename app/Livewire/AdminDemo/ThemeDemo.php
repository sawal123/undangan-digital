<?php

namespace App\Livewire\AdminDemo;

use App\Models\Theme;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ThemeDemo extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $nama, $category_id, $path, $demo, $thumbnail, $theme_id;
    public $isEdit = false;

    public function render()
    {
        $themes = Theme::with('category')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->orWhereHas('category', function($query) {
                $query->where('category', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin-demo.theme-demo', [
            'themes' => $themes,
            'categories' => Category::all()
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput()
    {
        $this->nama = '';
        $this->category_id = '';
        $this->path = '';
        $this->demo = '';
        $this->thumbnail = null;
        $this->theme_id = null;
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'category_id' => 'required',
            'path' => 'required|string|max:255',
            'demo' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|max:1024'
        ]);

        $data = [
            'nama' => $this->nama,
            'category_id' => $this->category_id,
            'path' => $this->path,
            'demo' => $this->demo,
        ];

        if ($this->thumbnail) {
            $data['thumbnail'] = $this->thumbnail->store('thumbnail', 'public');
        }

        Theme::create($data);

        session()->flash('message', 'Theme successfully created.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'theme-modal');
    }

    public function edit($id)
    {
        $theme = Theme::findOrFail($id);
        $this->theme_id = $id;
        $this->nama = $theme->nama;
        $this->category_id = $theme->category_id;
        $this->path = $theme->path;
        $this->demo = $theme->demo;
        $this->isEdit = true;
        
        $this->dispatch('open-modal', name: 'theme-modal');
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'category_id' => 'required',
            'path' => 'required|string|max:255',
            'demo' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|max:1024'
        ]);

        $theme = Theme::findOrFail($this->theme_id);
        
        $data = [
            'nama' => $this->nama,
            'category_id' => $this->category_id,
            'path' => $this->path,
            'demo' => $this->demo,
        ];

        if ($this->thumbnail) {
            if ($theme->thumbnail) {
                Storage::disk('public')->delete($theme->thumbnail);
            }
            $data['thumbnail'] = $this->thumbnail->store('thumbnail', 'public');
        }

        $theme->update($data);

        session()->flash('message', 'Theme successfully updated.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'theme-modal');
    }

    public function delete($id)
    {
        $theme = Theme::findOrFail($id);
        if ($theme->thumbnail) {
            Storage::disk('public')->delete($theme->thumbnail);
        }
        $theme->delete();
        session()->flash('message', 'Theme successfully deleted.');
    }
}
