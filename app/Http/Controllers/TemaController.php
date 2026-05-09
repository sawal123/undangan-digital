<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\KelolaUndangan\Acara;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\Galery;
use App\Models\KelolaUndangan\Ucapan;
use Illuminate\Support\Facades\Crypt;
use App\Models\KelolaUndangan\FiturUcapan;
use App\Models\KelolaUndangan\ThumbnailWa;

class TemaController extends Controller
{
    protected function getData($id)
    {
        return $tema = Crypt::decryptString($id);
    }
    public function index($slug)
    {
        // dd('tes');
        $tema = Data::where('slug', $slug)->first();
        return $tema;
    }
    public function demo($demo, $id = null)
    {
        error_reporting(0);
        try {
            $temaPath = Crypt::decryptString($demo);
            $dataId = Crypt::decryptString($id);
            
            $data = Data::with([
                'pria', 'wanita', 'acara', 'galery', 'sound', 
                'FiturUcapan', 'streaming', 'kado', 'imageKisah', 
                'kisah', 'dataFont.titleFont', 'dataFont.subFont', 
                'thumbnailWas', 'teksUndangan', 'coverUndangan'
            ])->findOrFail($dataId);

            $preparedData = $this->prepareInvitationData($data, 'Nama Tamu (Contoh)');
            
            return view($temaPath, $preparedData);
        } catch (\Exception $e) {
            \Log::error('Error saat demo tema: ' . $e->getMessage());
            return abort(404, 'Tema atau data tidak ditemukan.');
        }
    }

    public function temademo($demo)
    {
        return view($demo);
    }

    public function visit($slug, $tamu = null)
    {
        error_reporting(0);
        try {
            $data = Data::with([
                'theme', 'pria', 'wanita', 'acara', 'galery', 'sound', 
                'FiturUcapan', 'streaming', 'kado', 'imageKisah', 
                'kisah', 'dataFont.titleFont', 'dataFont.subFont', 
                'thumbnailWas', 'teksUndangan', 'coverUndangan'
            ])->where('slug', $slug)->firstOrFail();

            // Validasi theme
            if (is_null($data->theme_id) || !$data->theme) {
                session()->flash('message', 'Harap Pilih Tema Terlebih Dahulu!');
                return redirect()->back();
            }

            $preparedData = $this->prepareInvitationData($data, $tamu);

            return view($data->theme->path, $preparedData);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return abort(404, 'Undangan tidak ditemukan.');
        } catch (\Exception $e) {
            \Log::error('Error saat visit undangan: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan, silakan coba lagi.');
            return redirect()->back();
        }
    }

    protected function prepareInvitationData($data, $tamu = null)
    {
        // Pilih acara, default ke index 0 kalau index 1 nggak ada
        $acara = $data->acara[1] ?? $data->acara[0] ?? null;

        // Ambil thumbnail WhatsApp
        $thumbnailWa = $data->thumbnailWas;

        // Cari tamu berdasarkan kode
        $ta = $data->tamu()->where('kode', $tamu)->first();

        // Mapping hari & bulan
        $hari = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $bulan = [
            'Jan' => 'Januari',
            'Feb' => 'Februari',
            'Mar' => 'Maret',
            'Apr' => 'April',
            'May' => 'Mei',
            'Jun' => 'Juni',
            'Jul' => 'Juli',
            'Aug' => 'Agustus',
            'Sep' => 'September',
            'Oct' => 'Oktober',
            'Nov' => 'November',
            'Dec' => 'Desember',
        ];

        // Ambil galeri
        $video = $data->galery->pluck('video')->filter()->toArray();
        $poto  = $data->galery->pluck('poto')->filter()->toArray();

        // Ambil ucapan
        $ucapan = $data->ucapan;

        return [
            'data'        => $data,
            'hari'        => $hari,
            'bulan'       => $bulan,
            'tamu'        => $ta->nama ?? $tamu,
            'video'       => $video,
            'poto'        => $poto,
            'kode'        => $tamu,
            'ucapan'      => $ucapan,
            'acara'       => $acara,
            'thumbnailWa' => $thumbnailWa,
        ];
    }

    public function saveDoa(Request $request)
    {
        $va = $request->validate([
            'dataId' => 'required',
            'nama' => 'required|string|max:20',
            'ucapan' => 'required|string|max:255',
            'status' => 'required|string|max:255'
        ], [
            'nama.required' => 'Nama tidak boleh kosong.',
            'ucapan.required' => 'Ucapan tidak boleh kosong.',
            'ucapan.max' => 'Ucapan tidak boleh lebih dari 255 karakter.',
            'status.required' => 'Pilih Kehadiran Kamu.',
        ]);
        $tamu = null;
        $addTamu = null;
        $fitur = FiturUcapan::where('data_id', $va['dataId'])->first();
        $tamu = Tamu::where('kode', $request['kode'])->first();
        if (!$tamu && !$fitur->publicIsActive) {
            session()->flash('message', 'Anda Tidak Masuk Dalam Daftar Tamu Yang Diundang.');
            return redirect()->back();
        } elseif (!$tamu && $fitur->publicIsActive) {
            $addTamu =  Tamu::create([
                'data_id' => $va['dataId'],
                'kode' => 0,
                'nama' => $va['nama'],
                'slug' => Str::slug($va['nama'])
            ]);
        }

        $ucapan = Ucapan::create([
            'data_id' => $va['dataId'],
            'tamu_id' => $tamu ? $tamu->id : $addTamu->id,
            'ucapan' => $va['ucapan'],
            'status' => $va['status']
        ]);

        return redirect()->back()->with('message', 'Ucapan doa berhasil dikirim');
    }
}
