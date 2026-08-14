<?php

namespace App\Livewire\AdminDemo;

use App\Models\Category;
use App\Models\EventType;
use App\Models\Theme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ThemeDemo extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';

    public string $nama = '';

    public string $category_id = '';

    public string $event_type_id = '';

    public string $path = '';

    public string $demo = '';

    public $thumbnail;

    public ?int $theme_id = null;

    public bool $isEdit = false;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $themes = Theme::with(['category', 'eventType'])
            ->when(!empty(trim($this->search)), function ($query) {
                $searchTerm = '%' . trim($this->search) . '%';
                $query->where(function ($sub) use ($searchTerm) {
                    $sub->where('nama', 'like', $searchTerm)
                        ->orWhereHas('category', function ($q) use ($searchTerm) {
                            $q->where('category', 'like', $searchTerm);
                        })
                        ->orWhereHas('eventType', function ($q) use ($searchTerm) {
                            $q->where('name', 'like', $searchTerm);
                        });
                });
            })
            ->latest('id')
            ->paginate(10);

        return view('livewire.admin-demo.theme-demo', [
            'themes' => $themes,
            'categories' => Category::orderBy('category')->get(['id', 'category']),
            'eventTypes' => EventType::orderBy('name')->get(['id', 'name']),
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput(): void
    {
        $this->nama = '';
        $this->category_id = '';
        $this->event_type_id = (string) (EventType::where('key', 'wedding')->value('id') ?? '');
        $this->path = '';
        $this->demo = '';
        $this->thumbnail = null;
        $this->theme_id = null;
        $this->isEdit = false;
        $this->resetValidation();
    }

    public function create(): void
    {
        $this->resetInput();
        $this->dispatch('open-modal', name: 'theme-modal');
    }

    private function themeRules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'event_type_id' => 'required|exists:event_types,id',
            'path' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (! View::exists($value)) {
                        $fail('Path template tidak valid atau tidak ditemukan.');
                    }
                },
            ],
            'demo' => [
                'nullable',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if ($value && ! View::exists($value)) {
                        $fail('Template demo tidak valid atau tidak ditemukan.');
                    }
                },
            ],
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function store(): void
    {
        $this->validate($this->themeRules());

        $data = [
            'nama' => $this->nama,
            'category_id' => $this->category_id,
            'event_type_id' => $this->event_type_id,
            'path' => $this->path,
            'demo' => $this->demo,
        ];

        $newFile = null;
        if ($this->thumbnail) {
            $newFile = $this->thumbnail->store('thumbnail', 'public');
            $data['thumbnail'] = $newFile;
        }

        try {
            DB::transaction(function () use ($data) {
                Theme::create($data);
            });

            session()->flash('message', 'Tema berhasil dibuat.');
            $this->resetInput();
            $this->dispatch('close-modal', name: 'theme-modal');
        } catch (\Throwable $e) {
            if ($newFile) {
                Storage::disk('public')->delete($newFile);
            }
            session()->flash('error', 'Gagal membuat tema: ' . $e->getMessage());
        }
    }

    public function edit(int $id): void
    {
        $theme = Theme::findOrFail($id);
        $this->theme_id = $theme->id;
        $this->nama = $theme->nama;
        $this->category_id = (string) $theme->category_id;
        $this->event_type_id = (string) $theme->event_type_id;
        $this->path = $theme->path;
        $this->demo = $theme->demo ?? '';
        $this->thumbnail = null;
        $this->isEdit = true;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'theme-modal');
    }

    public function update(): void
    {
        if (!$this->theme_id) {
            return;
        }

        $this->validate($this->themeRules());

        $theme = Theme::findOrFail($this->theme_id);

        $data = [
            'nama' => $this->nama,
            'category_id' => $this->category_id,
            'event_type_id' => $this->event_type_id,
            'path' => $this->path,
            'demo' => $this->demo,
        ];

        $newFile = null;
        $oldFileToDelete = null;

        if ($this->thumbnail) {
            $newFile = $this->thumbnail->store('thumbnail', 'public');
            $data['thumbnail'] = $newFile;
            if ($theme->thumbnail) {
                $oldFileToDelete = $theme->thumbnail;
            }
        }

        try {
            DB::transaction(function () use ($theme, $data) {
                $theme->update($data);
            });

            if ($oldFileToDelete) {
                Storage::disk('public')->delete($oldFileToDelete);
            }

            session()->flash('message', 'Tema berhasil diperbarui.');
            $this->resetInput();
            $this->dispatch('close-modal', name: 'theme-modal');
        } catch (\Throwable $e) {
            if ($newFile) {
                Storage::disk('public')->delete($newFile);
            }
            session()->flash('error', 'Gagal memperbarui tema: ' . $e->getMessage());
        }
    }

    public function delete(int $id): void
    {
        $theme = Theme::findOrFail($id);
        $oldFile = $theme->thumbnail;

        $theme->delete();

        if ($oldFile) {
            Storage::disk('public')->delete($oldFile);
        }

        session()->flash('message', 'Tema berhasil dihapus.');
    }
}
