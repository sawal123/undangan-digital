<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Tamu as TamuModel;
use App\Models\KelolaUndangan\Ucapan as KelolaUndanganUcapan;
use App\Models\teksWhatsApp;
use App\Services\InvitationMessageRenderer;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Tamu extends Component
{
    use LoadsOwnedInvitation;
    use WithPagination;

    #[Locked]
    public int $dataId;

    #[Url(as: 'tab')]
    public string $activeTab = 'daftar';

    // Tamu (Tab 1) Properties
    public string $nama = '';
    public string $whatsapp = '';
    public string $query = '';
    public ?TamuModel $undang = null;
    public ?int $idTamu = null;
    public string $slug = '';
    public array $invite = [];
    public string $title = 'Add Tamu';
    public bool $canShareInvitation = false;

    // RSVP (Tab 2) Properties
    public string $rsvpFilter = 'all';
    public string $rsvpSearch = '';

    // Ucapan (Tab 3) Properties
    public ?FiturUcapan $fitUcapan = null;
    public string $ucapanQuery = '';
    public array $balas = [];

    public function updatedQuery(): void
    {
        $this->resetPage('tamuPage');
    }

    public function updatedRsvpSearch(): void
    {
        $this->resetPage('rsvpPage');
    }

    public function updatedUcapanQuery(): void
    {
        $this->resetPage('ucapanPage');
    }

    public function setTab(string $tab): void
    {
        if (in_array($tab, ['daftar', 'rsvp', 'ucapan'], true)) {
            $this->activeTab = $tab;
        }
    }

    public function mount(string $id): void
    {
        $data = $this->ownedInvitationByUid($id);
        $this->dataId = $data->id;
        $this->canShareInvitation = $data->canBeShared();

        $initialTab = request()->query('tab');
        if (in_array($initialTab, ['daftar', 'rsvp', 'ucapan'], true)) {
            $this->activeTab = $initialTab;
        }

        $this->loadFeatureSettings();
    }

    public function loadFeatureSettings(): void
    {
        $this->authorizeInvitationState();
        $this->fitUcapan = FiturUcapan::where('data_id', $this->dataId)->first();
    }

    public function close(): void
    {
        $this->dispatch('close-modal', name: 'delete-modal');
        $this->dispatch('close-modal', name: 'tamu-modal');
        $this->dispatch('close-modal', name: 'share-modal');
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

    // ==========================================
    // TAMU (TAB 1) ACTIONS
    // ==========================================

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

    // ==========================================
    // RSVP (TAB 2) ACTIONS
    // ==========================================

    public function setRsvpFilter(string $filter): void
    {
        $this->rsvpFilter = $filter;
        $this->resetPage('rsvpPage');
    }

    // ==========================================
    // UCAPAN (TAB 3) ACTIONS
    // ==========================================

    public function updateFiturUcapan(int $id, bool $isFitur, string $column): void
    {
        $this->authorizeInvitationState();
        abort_unless(in_array($column, ['isActive', 'publicIsActive', 'viewIsActive'], true), 422);

        FiturUcapan::updateOrCreate(
            ['data_id' => $this->dataId],
            [$column => $isFitur]
        );

        $this->loadFeatureSettings();
        session()->flash('message', 'Pengaturan ucapan berhasil diperbarui.');
    }

    public function tanggapi(int $id): void
    {
        $this->authorizeInvitationState();

        $this->validate([
            'balas.' . $id => 'nullable|string|max:1000',
        ], [
            'balas.' . $id . '.max' => 'Balasan tidak boleh melebihi 1000 karakter.',
        ]);

        $balas = trim((string) ($this->balas[$id] ?? ''));
        $ucapan = KelolaUndanganUcapan::where('data_id', $this->dataId)->findOrFail($id);
        $ucapan->balas = $balas !== '' ? $balas : null;
        $ucapan->save();

        unset($this->balas[$id]);
        session()->flash('message', 'Balasan ucapan berhasil disimpan.');
    }

    public function deleteUcapan(int $id): void
    {
        $this->authorizeInvitationState();
        $delete = KelolaUndanganUcapan::with('tamu')->where('data_id', $this->dataId)->findOrFail($id);
        $namaTamu = $delete->tamu?->nama ?? 'Tamu';
        $delete->delete();
        session()->flash('message', 'Ucapan & Doa dari ' . $namaTamu . ' berhasil dihapus.');
    }

    public function render()
    {
        $this->authorizeInvitationState();

        // 1. Data Tamu (Tab 1)
        $tamuList = TamuModel::where('data_id', $this->dataId)
            ->with('ucapans')
            ->when(!empty(trim($this->query)), function ($q) {
                $searchTerm = '%' . trim($this->query) . '%';
                $q->where(function ($sub) use ($searchTerm) {
                    $sub->where('nama', 'LIKE', $searchTerm)
                        ->orWhere('nomor', 'LIKE', $searchTerm)
                        ->orWhere('kode', 'LIKE', $searchTerm);
                });
            })
            ->latest('id')
            ->paginate(10, ['*'], 'tamuPage');

        // 2. Data RSVP & Kehadiran (Tab 2)
        $totalTamu = TamuModel::where('data_id', $this->dataId)->count();
        $totalHadir = KelolaUndanganUcapan::where('data_id', $this->dataId)->where('status', 'Hadir')->count();
        $totalTidakHadir = KelolaUndanganUcapan::where('data_id', $this->dataId)->where('status', 'Tidak Hadir')->count();
        $totalAkanHadir = KelolaUndanganUcapan::where('data_id', $this->dataId)->where('status', 'Akan Hadir')->count();
        $totalRespon = KelolaUndanganUcapan::where('data_id', $this->dataId)->count();
        $totalBelumRespon = max(0, $totalTamu - $totalRespon);

        $rsvpList = KelolaUndanganUcapan::with('tamu')
            ->where('data_id', $this->dataId)
            ->when($this->rsvpFilter !== 'all', function ($q) {
                $q->where('status', $this->rsvpFilter);
            })
            ->when(!empty(trim($this->rsvpSearch)), function ($q) {
                $term = '%' . trim($this->rsvpSearch) . '%';
                $q->where(function ($sub) use ($term) {
                    $sub->where('ucapan', 'LIKE', $term)
                        ->orWhere('status', 'LIKE', $term)
                        ->orWhereHas('tamu', fn ($t) => $t->where('nama', 'LIKE', $term));
                });
            })
            ->latest('id')
            ->paginate(10, ['*'], 'rsvpPage');

        // 3. Data Doa & Ucapan (Tab 3)
        $ucapanList = KelolaUndanganUcapan::with('tamu')
            ->where('data_id', $this->dataId)
            ->when(!empty(trim($this->ucapanQuery)), function ($query) {
                $searchTerm = '%' . trim($this->ucapanQuery) . '%';
                $query->where(function ($sub) use ($searchTerm) {
                    $sub->where('ucapan', 'LIKE', $searchTerm)
                        ->orWhere('status', 'LIKE', $searchTerm)
                        ->orWhere('balas', 'LIKE', $searchTerm)
                        ->orWhereHas('tamu', fn ($q) => $q->where('nama', 'LIKE', $searchTerm));
                });
            })
            ->latest('id')
            ->paginate(8, ['*'], 'ucapanPage');

        return view('livewire.dashboard.kelola.tamu', [
            'tamu' => $tamuList,
            'rsvpList' => $rsvpList,
            'ucapanList' => $ucapanList,
            'totalTamu' => $totalTamu,
            'totalHadir' => $totalHadir,
            'totalTidakHadir' => $totalTidakHadir,
            'totalAkanHadir' => $totalAkanHadir,
            'totalRespon' => $totalRespon,
            'totalBelumRespon' => $totalBelumRespon,
        ])->layout('components.layouts.user-new', [
            'headerTitle' => 'Manajemen Tamu & RSVP',
        ]);
    }
}
