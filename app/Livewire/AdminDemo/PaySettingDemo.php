<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\PaySetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class PaySettingDemo extends Component
{
    use WithFileUploads;

    public $bank;

    public $deskripsi;

    public $category;

    public $fee;

    public $image;

    public $pay_id;

    public $midtrans_code;

    public $isEdit = false;

    private array $categories = ['manual', 'bank_transfer', 'ewallet', 'credit_card', 'cstore'];

    public function render()
    {
        return view('livewire.admin-demo.pay-setting-demo', [
            'paySettings' => PaySetting::all(),
        ])->layout('components.layouts.admin-new');
    }

    public function resetInput()
    {
        $this->bank = '';
        $this->deskripsi = '';
        $this->category = '';
        $this->fee = '';
        $this->midtrans_code = '';
        $this->image = null;
        $this->pay_id = null;
        $this->isEdit = false;
    }

    public function toggleActive($id)
    {
        $p = PaySetting::findOrFail($id);
        $p->isActive = ! $p->isActive;
        $p->save();
    }

    public function store()
    {
        $this->validate([
            'bank' => 'required',
            'category' => ['required', Rule::in($this->categories)],
            'midtrans_code' => 'required|string|max:50',
            'fee' => 'required',
        ]);

        $imagePath = $this->image ? $this->image->store('paysetting', 'public') : null;

        PaySetting::create([
            'bank' => $this->bank,
            'category' => $this->category,
            'fee' => $this->fee,
            'deskripsi' => $this->deskripsi,
            'image' => $imagePath,
            'isActive' => true,
            'slug' => Str::slug($this->bank),
            'midtrans_code' => $this->midtrans_code,
        ]);

        session()->flash('message', 'Payment setting successfully created.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'pay-modal');
    }

    public function edit($id)
    {
        $p = PaySetting::findOrFail($id);
        $this->pay_id = $id;
        $this->bank = $p->bank;
        $this->category = $p->category;
        $this->fee = $p->fee;
        $this->midtrans_code = $p->midtrans_code;
        $this->deskripsi = $p->deskripsi;
        $this->isEdit = true;
        $this->dispatch('open-modal', name: 'pay-modal');
    }

    public function update()
    {
        $p = PaySetting::findOrFail($this->pay_id);

        $this->validate([
            'bank' => 'required',
            'category' => ['required', Rule::in($this->categories)],
            'midtrans_code' => 'required|string|max:50',
            'fee' => 'required',
        ]);

        $data = [
            'bank' => $this->bank,
            'category' => $this->category,
            'fee' => $this->fee,
            'deskripsi' => $this->deskripsi,
            'slug' => Str::slug($this->bank),
            'midtrans_code' => $this->midtrans_code,
        ];

        if ($this->image) {
            if ($p->image) {
                Storage::disk('public')->delete($p->image);
            }
            $data['image'] = $this->image->store('paysetting', 'public');
        }

        $p->update($data);

        session()->flash('message', 'Payment setting successfully updated.');
        $this->resetInput();
        $this->dispatch('close-modal', name: 'pay-modal');
    }

    public function delete($id)
    {
        $p = PaySetting::findOrFail($id);
        if ($p->image) {
            Storage::disk('public')->delete($p->image);
        }
        $p->delete();
        session()->flash('message', 'Payment setting successfully deleted.');
    }
}
