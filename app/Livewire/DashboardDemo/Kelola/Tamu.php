<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\Tamu as TamuModel;
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
    public int $dataId;

    public string $nama = '';

    public string $whatsapp = '';

    public string $query = '';

    public ?TamuModel $undang = null;

    public ?int $idTamu = null;

    public string $slug = '';

    public array $invite = [];

    public string $title = 'Add Tamu';

    public bool $canShareInvitation = false;

    public function updatedQuery(): void
    {
        $this->resetPage();
    }

    public function mount(string $id): void
    {
        $data = $this->ownedInvitationByUid($id);
        $this->dataId = $data->id;
        $this->canShareInvitation = $data->canBeShared();
    }

    public function close(): void
    {
        $this->dispatch('close-modal', name: 'delete-modal');
    }

    protected function normalizeWhatsAppNumber(?string $phone): string
    {
        if (empty($phone)) {
            return '';
        }
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($cleaned, '08')) {
            return '628' . substr($cleaned, 2);
        }
        return $cleaned;
    }

    public function shareWA(int $id): void
    {
        $this->authorizeInvitationState();
        $tamu = TamuModel::where('data_id', $this->dataId)->findOrFail($id);

        $data = $this->ownedInvitationById($this->dataId, ['eventType', 'pria', 'wanita', 'birthdayProfile', 'eventDetail']);

        if (!$data?->canBeShared()) {
            session()->flash('error', 'Undangan belum aktif, link belum bisa dibagikan.');
            return;
        }

        $pesan = teksWhatsApp::where('data_id', $this->dataId)->first()?->pesan;
        $pesanFinal = app(InvitationMessageRenderer::class)->render($data, $tamu, $pesan);

        $targetPhone = $this->normalizeWhatsAppNumber($tamu->nomor);
        if (empty($targetPhone)) {
            session()->flash('error', 'Nomor WhatsApp tamu belum diisi atau tidak valid.');
            return;
        }

        $pesanEncoded = rawurlencode($pesanFinal);
        $whatsappUrl = "https://wa.me/{$targetPhone}?text={$pesanEncoded}";

        $this->dispatch('open-new-tab', ['url' => $whatsappUrl]);
    }

    public function delete(string $kode): void
    {
        $this->authorizeInvitationState();
        $tamu = TamuModel::where('data_id', $this->dataId)->where('kode', $kode)->firstOrFail();
        $tamu->delete();
        session()->flash('message', 'Tamu berhasil dihapus.');
    }

    public function shareTamu(int $id): void
    {
        $this->authorizeInvitationState();
        $this->undang = TamuModel::with('data')->where('data_id', $this->dataId)->findOrFail($id);

        if (!$this->undang?->data?->canBeShared()) {
            session()->flash('error', 'Undangan belum aktif, link belum bisa dibagikan.');
            return;
        }

        $this->invite = [$this->undang->nama, $this->undang->kode];
        $this->slug = url('/u') . '/' . $this->undang->data->slug . '/' . $this->undang->kode;
        $this->dispatch('open-modal', name: 'share-modal');
    }

    public function EditTamu(int $id): void
    {
        $this->authorizeInvitationState();
        $tamu = TamuModel::where('data_id', $this->dataId)->findOrFail($id);

        $this->idTamu = $tamu->id;
        $this->nama = $tamu->nama;
        $this->whatsapp = $tamu->nomor ?? '';
        $this->title = 'Edit Tamu';
        $this->resetValidation();

        $this->dispatch('open-modal', name: 'tamu-modal');
    }

    public function openAddTamu(): void
    {
        $this->resetField();
        $this->title = 'Add Tamu';
        $this->dispatch('open-modal', name: 'tamu-modal');
    }

    public function save(): void
    {
        $this->authorizeInvitationState();
        $this->validate([
            'nama' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:30',
        ], [
            'nama.required' => 'Nama tamu wajib diisi.',
        ]);

        $normalizedPhone = $this->normalizeWhatsAppNumber($this->whatsapp);

        $tamu = $this->idTamu ? TamuModel::where('data_id', $this->dataId)->where('id', $this->idTamu)->first() : null;

        if ($tamu) {
            $tamu->update([
                'nama' => trim($this->nama),
                'nomor' => $normalizedPhone,
            ]);
            session()->flash('message', 'Tamu berhasil diperbarui.');
        } else {
            $kode = $this->generateGuestCode();
            TamuModel::create([
                'data_id' => $this->dataId,
                'nama' => trim($this->nama),
                'kode' => $kode,
                'nomor' => $normalizedPhone,
                'slug' => Str::slug($this->nama),
            ]);
            session()->flash('message', 'Tamu berhasil ditambahkan.');
        }

        $this->resetField();
        $this->dispatch('close-modal', name: 'tamu-modal');
    }

    public function resetField(): void
    {
        $this->nama = '';
        $this->whatsapp = '';
        $this->idTamu = null;
        $this->title = 'Add Tamu';
        $this->resetValidation();
    }

    private function generateGuestCode(): string
    {
        do {
            $kode = Str::lower(Str::random(12));
        } while (TamuModel::where('data_id', $this->dataId)->where('kode', $kode)->exists());

        return $kode;
    }

    public function render()
    {
        $this->authorizeInvitationState();

        $tamu = TamuModel::where('data_id', $this->dataId)
            ->when(!empty(trim($this->query)), function ($q) {
                $searchTerm = '%' . trim($this->query) . '%';
                $q->where(function ($sub) use ($searchTerm) {
                    $sub->where('nama', 'LIKE', $searchTerm)
                        ->orWhere('nomor', 'LIKE', $searchTerm)
                        ->orWhere('kode', 'LIKE', $searchTerm);
                });
            })
            ->latest('id')
            ->paginate(5);

        return view('livewire.dashboard.kelola.tamu', [
            'tamu' => $tamu,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Daftar Tamu',
        ]);
    }
}
