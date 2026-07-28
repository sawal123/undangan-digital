<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\PaySetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class PaySettingDemo extends Component
{
    use WithFileUploads;

    public string $bank = '';

    public string $deskripsi = '';

    public string $category = '';

    public string $fee = '';

    public $image;

    public ?int $pay_id = null;

    public string $midtrans_code = '';

    public bool $isEdit = false;

    private array $categories = ['manual', 'bank_transfer', 'ewallet', 'credit_card', 'cstore'];

    public function render()
    {
        return view('livewire.admin-demo.pay-setting-demo', [
            'paySettings' => PaySetting::orderBy('bank')->get(),
            'midtransCodes' => $this->allowedMidtransCodes($this->category),
            'feeLabel' => $this->feeLabel(),
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput(): void
    {
        $this->bank = '';
        $this->deskripsi = '';
        $this->category = '';
        $this->fee = '';
        $this->midtrans_code = '';
        $this->image = null;
        $this->pay_id = null;
        $this->isEdit = false;
        $this->resetValidation();
    }

    public function toggleActive(int $id): void
    {
        $p = PaySetting::findOrFail($id);
        $p->isActive = !$p->isActive;
        $p->save();
        session()->flash('message', 'Status metode pembayaran berhasil diperbarui.');
    }

    public function updatedCategory(): void
    {
        $allowedCodes = $this->allowedMidtransCodes($this->category);

        if (!in_array($this->midtrans_code, $allowedCodes, true)) {
            $this->midtrans_code = $allowedCodes[0] ?? '';
        }
    }

    public function store(): void
    {
        $this->validate($this->rules());

        $newImage = null;
        if ($this->image) {
            $newImage = $this->image->store('paysetting', 'public');
        }

        try {
            DB::transaction(function () use ($newImage) {
                PaySetting::create([
                    'bank' => trim($this->bank),
                    'category' => $this->category,
                    'fee' => (int) $this->fee,
                    'deskripsi' => trim($this->deskripsi),
                    'image' => $newImage,
                    'isActive' => true,
                    'slug' => Str::slug($this->bank),
                    'midtrans_code' => $this->midtrans_code,
                ]);
            });

            session()->flash('message', 'Metode pembayaran berhasil dibuat.');
            $this->resetInput();
            $this->dispatch('close-modal', name: 'pay-modal');
        } catch (\Throwable $e) {
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }
            session()->flash('error', 'Gagal menyimpan metode pembayaran: ' . $e->getMessage());
        }
    }

    public function edit(int $id): void
    {
        $p = PaySetting::findOrFail($id);
        $this->pay_id = $p->id;
        $this->bank = $p->bank;
        $this->category = $p->category;
        $this->fee = (string) $p->fee;
        $this->midtrans_code = $p->midtrans_code;
        $this->deskripsi = $p->deskripsi ?? '';
        $this->image = null;
        $this->isEdit = true;
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'pay-modal');
    }

    public function update(): void
    {
        if (!$this->pay_id) {
            return;
        }

        $p = PaySetting::findOrFail($this->pay_id);
        $this->validate($this->rules());

        $data = [
            'bank' => trim($this->bank),
            'category' => $this->category,
            'fee' => (int) $this->fee,
            'deskripsi' => trim($this->deskripsi),
            'slug' => Str::slug($this->bank),
            'midtrans_code' => $this->midtrans_code,
        ];

        $newImage = null;
        $oldImageToDelete = null;

        if ($this->image) {
            $newImage = $this->image->store('paysetting', 'public');
            $data['image'] = $newImage;
            if ($p->image) {
                $oldImageToDelete = $p->image;
            }
        }

        try {
            DB::transaction(function () use ($p, $data) {
                $p->update($data);
            });

            if ($oldImageToDelete) {
                Storage::disk('public')->delete($oldImageToDelete);
            }

            session()->flash('message', 'Metode pembayaran berhasil diperbarui.');
            $this->resetInput();
            $this->dispatch('close-modal', name: 'pay-modal');
        } catch (\Throwable $e) {
            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }
            session()->flash('error', 'Gagal memperbarui metode pembayaran: ' . $e->getMessage());
        }
    }

    public function delete(int $id): void
    {
        $p = PaySetting::findOrFail($id);
        $oldImage = $p->image;

        $p->delete();

        if ($oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        session()->flash('message', 'Metode pembayaran berhasil dihapus.');
    }

    private function rules(): array
    {
        $feeRules = ['required', 'numeric', 'min:0'];

        if ($this->category === 'ewallet') {
            $feeRules[] = 'max:100';
        }

        return [
            'bank' => 'required|string|max:255',
            'category' => ['required', Rule::in($this->categories)],
            'midtrans_code' => ['required', 'string', 'max:50', Rule::in($this->allowedMidtransCodes($this->category))],
            'fee' => $feeRules,
            'deskripsi' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ];
    }

    private function allowedMidtransCodes(?string $category): array
    {
        return match ($category) {
            'manual' => ['manual'],
            'bank_transfer' => ['bank_transfer', 'bca_va', 'bni_va', 'bri_va', 'permata_va', 'echannel'],
            'ewallet' => ['gopay', 'shopeepay', 'qris'],
            'credit_card' => ['credit_card'],
            'cstore' => ['cstore', 'alfamart', 'indomaret'],
            default => [],
        };
    }

    private function feeLabel(): string
    {
        return $this->category === 'ewallet' ? 'Fee (%)' : 'Fee (Rp)';
    }
}
