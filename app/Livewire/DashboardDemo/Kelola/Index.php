<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use Livewire\Component;

class Index extends Component
{
    use LoadsOwnedInvitation;

    public $dataId;

    public $data;

    public function mount($id)
    {
        $this->data = $this->ownedInvitationByUid($id, ['eventType']);
        $this->dataId = $this->data->id;
    }

    public function render()
    {
        $commonModules = [
            ['nama' => 'Acara', 'icon' => 'calendar', 'url' => 'acara', 'desc' => 'Kelola jadwal & lokasi'],
            ['nama' => 'Galeri', 'icon' => 'image', 'url' => 'galeri', 'desc' => 'Foto & video momen'],
            ['nama' => 'Musik', 'icon' => 'music', 'url' => 'musik', 'desc' => 'Pilih latar musik'],
            ['nama' => 'Ucapan', 'icon' => 'message-square', 'url' => 'ucapan', 'desc' => 'Doa & ucapan tamu'],
            ['nama' => 'Kado', 'icon' => 'gift', 'url' => 'kado', 'desc' => 'Kirim kado & hadiah'],
            ['nama' => 'Tamu', 'icon' => 'users', 'url' => 'tamu', 'desc' => 'Daftar & sebar undangan'],
            ['nama' => 'Tema', 'icon' => 'palette', 'url' => 'tema', 'desc' => 'Pilih desain undangan'],
            ['nama' => 'Setting', 'icon' => 'settings', 'url' => 'setting', 'desc' => 'Pengaturan umum'],
            ['nama' => 'Buku Tamu', 'icon' => 'book-open', 'url' => 'buku-tamu', 'desc' => 'Catatan kehadiran tamu'],
        ];

        $weddingModules = [
            ['nama' => 'Pengantin', 'icon' => 'user', 'url' => 'pengantin', 'desc' => 'Atur data mempelai'],
            ['nama' => 'Streaming', 'icon' => 'video', 'url' => 'streaming', 'desc' => 'Link siaran langsung'],
            ['nama' => 'Kisah Cinta', 'icon' => 'heart', 'url' => 'kisah-cinta', 'desc' => 'Ceritakan perjalanan anda'],
        ];

        $eventModules = match ($this->data->eventType?->key) {
            'birthday' => [
                ['nama' => 'Profil Ulang Tahun', 'icon' => 'cake', 'url' => 'birthday', 'desc' => 'Data yang berulang tahun'],
            ],
            'engagement' => [
                ['nama' => 'Detail Tunangan', 'icon' => 'gem', 'url' => 'detail-event', 'desc' => 'Data utama pertunangan'],
            ],
            'pengajian' => [
                ['nama' => 'Detail Pengajian', 'icon' => 'book-open-text', 'url' => 'detail-event', 'desc' => 'Tema dan pengisi acara'],
            ],
            'event' => [
                ['nama' => 'Detail Event', 'icon' => 'calendar-days', 'url' => 'detail-event', 'desc' => 'Data utama event'],
            ],
            default => $weddingModules,
        };

        $modules = array_merge(
            array_slice($eventModules, 0, 1),
            $commonModules,
            array_slice($eventModules, 1)
        );

        return view('livewire.dashboard.kelola.index', [
            'modules' => $modules,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Undangan',
        ]);
    }
}
