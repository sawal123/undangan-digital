<?php

namespace App\Livewire\AdminDemo;

use App\Models\GiftPay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class GiftPayDemo extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $search = '';

    public string $nama_pay = '';

    public $icon = null;

    public ?string $existingIcon = null;

    public ?int $gift_id = null;

    public bool $isEdit = false;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = GiftPay::query()->withCount('kado');

        if (!empty(trim($this->search))) {
            $searchTerm = '%' . trim($this->search) . '%';
            $query->where('nama_pay', 'like', $searchTerm);
        }

        $giftPays = $query->orderBy('nama_pay')->paginate(12);

        return view('livewire.admin-demo.gift-pay-demo', [
            'giftPays' => $giftPays,
            'totalCount' => GiftPay::count(),
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput(): void
    {
        $this->nama_pay = '';
        $this->icon = null;
        $this->existingIcon = null;
        $this->gift_id = null;
        $this->isEdit = false;
        $this->resetValidation();
    }

    public function create(): void
    {
        $this->resetInput();
        $this->dispatch('open-modal', name: 'gift-modal');
    }

    public function store(): void
    {
        $this->validate([
            'nama_pay' => 'required|string|max:255|unique:gift_pays,nama_pay',
            'icon' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ], [
            'nama_pay.required' => 'Nama bank atau e-wallet wajib diisi.',
            'nama_pay.unique' => 'Nama bank atau e-wallet sudah terdaftar.',
            'icon.required' => 'Icon / logo bank atau e-wallet wajib diunggah.',
            'icon.image' => 'File harus berupa gambar.',
            'icon.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $iconPath = null;
        if ($this->icon) {
            $iconPath = $this->icon->store('gift', 'public');
        }

        try {
            DB::transaction(function () use ($iconPath) {
                GiftPay::create([
                    'nama_pay' => trim($this->nama_pay),
                    'icon' => $iconPath,
                ]);
            });

            session()->flash('message', 'Gift pay berhasil ditambahkan.');
            $this->resetInput();
            $this->dispatch('close-modal', name: 'gift-modal');
        } catch (\Throwable $e) {
            if ($iconPath && Storage::disk('public')->exists($iconPath)) {
                Storage::disk('public')->delete($iconPath);
            }
            session()->flash('error', 'Gagal menyimpan gift pay: ' . $e->getMessage());
        }
    }

    public function edit(int $id): void
    {
        $gift = GiftPay::findOrFail($id);
        $this->gift_id = $gift->id;
        $this->nama_pay = $gift->nama_pay;
        $this->existingIcon = $gift->icon;
        $this->icon = null;
        $this->isEdit = true;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'gift-modal');
    }

    public function update(): void
    {
        if (!$this->gift_id) {
            return;
        }

        $gift = GiftPay::findOrFail($this->gift_id);

        $this->validate([
            'nama_pay' => ['required', 'string', 'max:255', Rule::unique('gift_pays', 'nama_pay')->ignore($gift->id)],
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ], [
            'nama_pay.required' => 'Nama bank atau e-wallet wajib diisi.',
            'nama_pay.unique' => 'Nama bank atau e-wallet sudah digunakan.',
            'icon.image' => 'File harus berupa gambar.',
            'icon.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $newIcon = null;
        $oldIconToDelete = null;

        if ($this->icon) {
            $newIcon = $this->icon->store('gift', 'public');
            if ($gift->icon && Storage::disk('public')->exists($gift->icon)) {
                $oldIconToDelete = $gift->icon;
            }
        }

        try {
            DB::transaction(function () use ($gift, $newIcon) {
                $data = [
                    'nama_pay' => trim($this->nama_pay),
                ];
                if ($newIcon) {
                    $data['icon'] = $newIcon;
                }
                $gift->update($data);
            });

            if ($oldIconToDelete) {
                Storage::disk('public')->delete($oldIconToDelete);
            }

            session()->flash('message', 'Gift pay berhasil diperbarui.');
            $this->resetInput();
            $this->dispatch('close-modal', name: 'gift-modal');
        } catch (\Throwable $e) {
            if ($newIcon && Storage::disk('public')->exists($newIcon)) {
                Storage::disk('public')->delete($newIcon);
            }
            session()->flash('error', 'Gagal memperbarui gift pay: ' . $e->getMessage());
        }
    }

    public function delete(int $id): void
    {
        $gift = GiftPay::findOrFail($id);
        $oldIcon = $gift->icon;

        try {
            DB::transaction(function () use ($gift) {
                $gift->delete();
            });

            if ($oldIcon && Storage::disk('public')->exists($oldIcon)) {
                Storage::disk('public')->delete($oldIcon);
            }

            session()->flash('message', 'Gift pay berhasil dihapus.');
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal menghapus gift pay: ' . $e->getMessage());
        }
    }
}
