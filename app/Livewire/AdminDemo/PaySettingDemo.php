<?php

namespace App\Livewire\AdminDemo;

use App\Models\Admin\PaySetting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PaySettingDemo extends Component
{
    use WithFileUploads;

    public $bank, $deskripsi, $category, $fee, $image, $pay_id;
    public $isEdit = false;

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
        $this->image = null;
        $this->pay_id = null;
        $this->isEdit = false;
    }

    public function toggleActive($id)
    {
        $p = PaySetting::findOrFail($id);
        $p->isActive = !$p->isActive;
        $p->save();
    }

    public function store()
    {
        $this->validate([
            'bank' => 'required',
            'category' => 'required',
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
            'slug' => Str::slug($this->bank)
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
        $this->deskripsi = $p->deskripsi;
        $this->isEdit = true;
        $this->dispatch('open-modal', name: 'pay-modal');
    }

    public function update()
    {
        $p = PaySetting::findOrFail($this->pay_id);
        
        $data = [
            'bank' => $this->bank,
            'category' => $this->category,
            'fee' => $this->fee,
            'deskripsi' => $this->deskripsi,
            'slug' => Str::slug($this->bank)
        ];

        if ($this->image) {
            if ($p->image) Storage::disk('public')->delete($p->image);
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
        if ($p->image) Storage::disk('public')->delete($p->image);
        $p->delete();
        session()->flash('message', 'Payment setting successfully deleted.');
    }
}
