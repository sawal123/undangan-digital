<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\Tamu as KelolaUndanganTamu;
use App\Models\KelolaUndangan\Tamu as Tamus;
use App\Models\teksWhatsApp;
use App\Services\InvitationMessageRenderer;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithPagination;

class Tamu extends Component
{
    use LoadsOwnedInvitation;
    use WithPagination;

    #[Locked]
    public $dataId;

    public $nama;

    public $whatsapp;

    public $query;

    public $undang;

    public $idTamu = null;

    public $slug = '';

    public $invite = [];

    public $title = 'Add Tamu';

    public bool $canShareInvitation = false;

    public function mount($id)
    {
        $data = $this->ownedInvitationByUid($id);
        $this->dataId = $data->id;
        $this->canShareInvitation = $data->canBeShared();
    }

    public function close()
    {
        $this->dispatch('close-modal', name: 'delete-modal');
    }

    public function shareWA($id)
    {
        $this->authorizeInvitationState();
        $this->undang = Tamus::where('data_id', $this->dataId)->findOrFail($id);
        if (! $this->undang) {
            session()->flash('error', 'Data tamu tidak ditemukan.');

            return;
        }

        $data = $this->ownedInvitationById($this->dataId, ['eventType', 'pria', 'wanita', 'birthdayProfile', 'eventDetail']);

        if (! $data?->canBeShared()) {
            session()->flash('error', 'Undangan belum aktif, link belum bisa dibagikan.');

            return;
        }

        if ($this->undang) {
            $pesan = teksWhatsApp::where('data_id', $this->dataId)->first()?->pesan;
            $pesanFinal = app(InvitationMessageRenderer::class)->render($data, $this->undang, $pesan);

            // Mengonversi teks pesan ke URL encoded
            $this->undang->nomor = preg_replace('/^08/', '628', $this->undang->nomor);

            $pesanEncoded = urlencode($pesanFinal);
            $whatsappUrl = "https://wa.me/{$this->undang->nomor}/?text={$pesanEncoded}";

            $this->dispatch('open-new-tab', ['url' => $whatsappUrl]);
        }
    }

    public function delete($kode)
    {
        $this->authorizeInvitationState();
        $tamu = Tamus::where('data_id', $this->dataId)->where('kode', $kode)->firstOrFail();
        $tamu->delete();
        session()->flash('message', 'Tamu Berhasil Didelete.');
    }

    public function shareTamu($id)
    {
        $this->authorizeInvitationState();
        $this->undang = Tamus::with('data')->where('data_id', $this->dataId)->findOrFail($id);

        if (! $this->undang?->data?->canBeShared()) {
            session()->flash('error', 'Undangan belum aktif, link belum bisa dibagikan.');

            return;
        }

        if ($this->undang) {
            $this->invite = [$this->undang->nama, $this->undang->kode];
        }
        $this->slug = url('/u').'/'.$this->undang->data->slug.'/'.$this->undang->kode;
        $this->dispatch('open-modal', name: 'share-modal');
    }

    public function EditTamu($id)
    {
        $this->authorizeInvitationState();
        $this->undang = Tamus::where('data_id', $this->dataId)->findOrFail($id);

        $this->idTamu = $this->undang->id;
        $this->nama = $this->undang->nama;
        $this->whatsapp = $this->undang->nomor;

        $this->dispatch('open-modal', name: 'tamu-modal');
        $this->title = 'Edit Tamu';
    }

    public function save()
    {
        $this->authorizeInvitationState();
        $this->validate([
            'nama' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:30',
        ]);

        $tamu = KelolaUndanganTamu::where('data_id', $this->dataId)->where('id', $this->idTamu)->first();
        if ($tamu) {
            $tamu->update([
                'nama' => $this->nama,
                'nomor' => $this->whatsapp,
            ]);
            session()->flash('message', 'Tamu Berhasil DiUpdate.');
            $this->dispatch('close-modal', name: 'tamu-modal');
        } else {
            $kode = $this->generateGuestCode();
            KelolaUndanganTamu::create([
                'data_id' => $this->dataId,
                'nama' => $this->nama,
                'kode' => $kode,
                'nomor' => $this->whatsapp,
                'slug' => Str::slug($this->nama),
            ]);
            session()->flash('message', 'Tamu Berhasil Ditambahkan.');
            $this->dispatch('close-modal', name: 'tamu-modal');
        }

        KelolaUndanganTamu::where('data_id', $this->dataId)->get();
        $this->resetField();
    }

    public function resetField()
    {
        $this->nama = '';
        $this->whatsapp = '';
    }

    private function generateGuestCode(): string
    {
        do {
            $kode = Str::lower(Str::random(12));
        } while (KelolaUndanganTamu::where('data_id', $this->dataId)->where('kode', $kode)->exists());

        return $kode;
    }

    public function render()
    {
        $this->authorizeInvitationState();

        $tamu = empty($this->query)
            ? KelolaUndanganTamu::orderBy('id', 'desc')->where('data_id', $this->dataId)->paginate(5)
            : KelolaUndanganTamu::where('data_id', $this->dataId)
                ->where(function ($query) {
                    $query->where('nama', 'LIKE', '%'.$this->query.'%')
                        ->orWhere('kode', 'LIKE', '%'.$this->query.'%')
                        ->orWhere('nomor', 'LIKE', '%'.$this->query.'%');
                })
                ->orderBy('id', 'desc')->paginate(5);

        return view('livewire.dashboard.kelola.tamu', [
            'tamu' => $tamu,
            'canShareInvitation' => $this->canShareInvitation,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Kelola Tamu',
        ]);
    }
}
