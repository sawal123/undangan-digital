<?php

namespace App\Livewire\Ucapan;

use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\Ucapan as KelolaUndanganUcapan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Ucapan extends Component
{
    public $dataId;

    public $kode;

    public $nama;

    public $ucapan;

    public $status;

    public $publicIsActive;

    public $viewIsActive;

    public $isActive;

    public $tamu;

    public bool $invitationIsActive = false;

    public $success = false;

    public $error = false;

    public $message;

    protected $rules = [
        'nama' => 'required|string|max:20',
        'ucapan' => 'required|string|max:255',
        'status' => 'required|string|max:255',
    ];

    protected $messages = [
        'nama.required' => 'Nama tidak boleh kosong.',
        'ucapan.required' => 'Ucapan tidak boleh kosong.',
        'ucapan.max' => 'Ucapan tidak boleh lebih dari 255 karakter.',
        'status.required' => 'Pilih Kehadiran Kamu.',
    ];

    public $theme;

    public function mount($data, $tamu, $kode = null)
    {
        $this->dataId = $data->id;
        $this->publicIsActive = $data->FiturUcapan->publicIsActive ?? false;
        $this->viewIsActive = $data->FiturUcapan->viewIsActive ?? false;
        $this->isActive = $data->FiturUcapan->isActive ?? false;
        $this->invitationIsActive = $data->canBeShared();
        $this->tamu = $tamu;
        $this->kode = $kode;
        $this->nama = $tamu; // isi default kalau ada
        $this->theme = Str::afterLast($data->theme->demo, '.'); // hasil: flowerone
        $this->status = 'Datang Dong';
        // dd($data);
    }

    public function save()
    {
        $this->validate([
            'nama' => 'required|string|max:20',
            'ucapan' => 'required|string|max:255',
            'status' => ['required', Rule::in(['hadir', 'tidak_hadir', 'tidak_datang', 'Hadir', 'Tidak Hadir', 'ragu', 'Datang Dong'])],
        ]);

        if (! $this->invitationIsActive || ! $this->isActive) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Fitur ucapan tidak tersedia.',
            ]);

            return;
        }

        $fitur = FiturUcapan::where('data_id', $this->dataId)->first();

        if (! $fitur) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Fitur ucapan tidak tersedia.',
            ]);

            return;
        }

        $tamu = null;
        $addTamu = null;

        if ($this->kode) {
            $tamu = Tamu::where('data_id', $this->dataId)->where('kode', $this->kode)->first();
        }

        if (! $tamu && ! $fitur->publicIsActive) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Anda Tidak Masuk Dalam Daftar Tamu Yang Diundang.',
            ]);

            return;
        } elseif (! $tamu && $fitur->publicIsActive) {
        }

        DB::transaction(function () use ($tamu, &$addTamu, $fitur) {
            if (! $tamu && $fitur->publicIsActive) {
                $addTamu = Tamu::create([
                    'data_id' => $this->dataId,
                    'kode' => Str::lower(Str::random(12)),
                    'nama' => $this->nama,
                    'slug' => Str::slug($this->nama),
                ]);
            }

            KelolaUndanganUcapan::create([
                'data_id' => $this->dataId,
                'tamu_id' => $tamu ? $tamu->id : $addTamu->id,
                'ucapan' => $this->ucapan,
                'status' => $this->status,
            ]);
        });

        // reset form setelah simpan
        $this->reset(['nama', 'ucapan', 'status']);
        $this->success = true;
        $this->error = false;
        $this->message = 'Ucapan berhasil dikirim!';
    }

    public function render()
    {

        $u = KelolaUndanganUcapan::where('data_id', $this->dataId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.ucapan.'.$this->theme, [
            'listUcapan' => $u,

        ]);
    }
}
