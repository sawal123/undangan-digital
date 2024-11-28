<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\PaySetting as AdminPaySetting;

class PaySetting extends Component
{
    use WithFileUploads;
    public $id = null;
    public $bank;
    public $deskripsi;
    public $image = null;
    public $category;
    public $fee;
    public $paySet;
    public $noTempo = null;
    public $teks = "Simpan";
    public $submit = "save";

    public function mount()
    {
        $this->paySet = AdminPaySetting::all();
    }
    public function isActive($id){
        $p = AdminPaySetting::find($id);
        if($p->isActive === 0){
            $p->isActive = 1;
        }else{
            $p->isActive =0;
        }
        $p->save();
        $this->mount();
    }
    public function delete($id)
    {
        $paySet = AdminPaySetting::find($id);
        if ($paySet) {
            if ($paySet->image) {
                Storage::delete('public/' . $paySet->image);
            }
            $paySet->delete();
            $this->mount();
            session()->flash('message', 'Data Payment berhasil Dihapus.');
        }
    }
    public function edit($id)
    {
        $paySet = AdminPaySetting::find($id);
        $this->bank = $paySet->bank;
        $this->deskripsi = $paySet->deskripsi;
        $this->image = "";
        $this->noTempo = $paySet->image;
        $this->category = $paySet->category;
        $this->fee = $paySet->fee;
        $this->id = $paySet->id;
        $this->teks = "Update";
        $this->submit = "update";
    }
    public function fieldReset()
    {
        $this->bank = "";
        $this->deskripsi = "";
        $this->image = "";
        $this->noTempo = "";
        $this->category = "";
        $this->fee = "";
        $this->id = null;
    }
    public function update()
    {
        $imagePath = null;
        $paySet = AdminPaySetting::find($this->id);
        if (is_object($this->image)) {
            // Hapus gambar lama jika ada, baru simpan yang baru
            if ($paySet && $paySet->image) {
                Storage::delete('public/' . $paySet->image);
            }
            $imagePath = $this->image->store('paysetting', 'public');
        }

        if ($paySet) {

            $paySet->update([
                'bank' => $this->bank,
                'category' => $this->category,
                'fee' => $this->fee,
                'deskripsi' => $this->deskripsi,
                'image' => $imagePath ? $imagePath : $paySet->image,
                'isActive' => true,
                'slug' => Str::slug($this->bank)
            ]);
            session()->flash('message', 'Data Payment berhasil diUbah.');
            $this->mount();
            $this->fieldReset();
        }
    }
    public function save()
    {
        $imagePath = is_object($this->image) ? $this->image->store('paysetting', 'public') : null;
        AdminPaySetting::create([
            'bank' => $this->bank,
            'category' => $this->category,
            'fee' => $this->fee,
            'deskripsi' => $this->deskripsi,
            'image' => $imagePath,
            'isActive' => true,
            'slug' => Str::slug($this->bank)
        ]);
        session()->flash('message', 'Data Payment berhasil disimpan.');
        $this->fieldReset();
        $this->mount();
    }
    public function render()
    {
        if ($this->image) {
            $this->noTempo = null;
        }
        return view('livewire.admin.pay-setting');
    }
}
