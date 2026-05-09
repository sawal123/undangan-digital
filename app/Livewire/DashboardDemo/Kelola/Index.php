<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Models\Data;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class Index extends Component
{
    public $dataId;
    public $data;

    public function mount($id)
    {
        $this->dataId = Crypt::decryptString($id);
        $this->data = Data::findOrFail($this->dataId);
    }

    public function render()
    {
        $modules = [
            ['nama' => 'Pengantin', 'icon' => 'user', 'url' => 'pengantin', 'desc' => 'Atur data mempelai'],
            ['nama' => 'Acara', 'icon' => 'calendar', 'url' => 'acara', 'desc' => 'Kelola jadwal & lokasi'],
            ['nama' => 'Galeri', 'icon' => 'image', 'url' => 'galeri', 'desc' => 'Foto & video momen'],
            ['nama' => 'Musik', 'icon' => 'music', 'url' => 'musik', 'desc' => 'Pilih latar musik'],
            ['nama' => 'Ucapan', 'icon' => 'message-square', 'url' => 'ucapan', 'desc' => 'Doa & ucapan tamu'],
            ['nama' => 'Kado', 'icon' => 'gift', 'url' => 'kado', 'desc' => 'Kirim kado & angpao'],
            ['nama' => 'Tamu', 'icon' => 'users', 'url' => 'tamu', 'desc' => 'Daftar & sebar undangan'],
            ['nama' => 'Streaming', 'icon' => 'video', 'url' => 'streaming', 'desc' => 'Link siaran langsung'],
            ['nama' => 'Kisah Cinta', 'icon' => 'heart', 'url' => 'kisah-cinta', 'desc' => 'Ceritakan perjalanan anda'],
            ['nama' => 'Tema', 'icon' => 'palette', 'url' => 'tema', 'desc' => 'Pilih desain undangan'],
            ['nama' => 'Setting', 'icon' => 'settings', 'url' => 'setting', 'desc' => 'Pengaturan umum'],
            ['nama' => 'Buku Tamu', 'icon' => 'book-open', 'url' => 'buku-tamu', 'desc' => 'Catatan kehadiran tamu'],
        ];

        return view('livewire.dashboard.kelola.index', [
            'modules' => $modules
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Undangan'
        ]);
    }
}
