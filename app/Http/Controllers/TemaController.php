<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\Ucapan;
use Illuminate\Support\Facades\Crypt;
use App\Models\KelolaUndangan\FiturUcapan;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TemaController extends Controller
{
    protected function getData($id)
    {
        return Crypt::decryptString($id);
    }

    public function index($slug)
    {
        return Data::where('slug', $slug)->first();
    }

    public function demo($demo, $id = null)
    {
        try {
            $temaPath = Crypt::decryptString($demo);
            
            // Menggabungkan pencarian dan pemuatan relasi menjadi 1 kueri efisien
            $data = Data::with([
                'pria', 'wanita', 'acara', 'galery', 'sound', 
                'FiturUcapan', 'streaming', 'kado', 'fiturKado', 'imageKisah', 
                'kisah.image', 'dataFont.titleFont', 'dataFont.subFont', 
                'thumbnailWas', 'teksUndangan', 'coverUndangan',
                'setting', 'qoute', 'teksPenutup'
            ])->where('uid', $id)->firstOrFail();

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
        try {
            $data = Data::with([
                'theme', 'pria', 'wanita', 'acara', 'galery', 'sound', 
                'FiturUcapan', 'streaming', 'kado', 'fiturKado', 'imageKisah', 
                'kisah.image', 'dataFont.titleFont', 'dataFont.subFont', 
                'thumbnailWas', 'teksUndangan', 'coverUndangan',
                'setting', 'qoute', 'teksPenutup'
            ])->where('slug', $slug)->firstOrFail();

            // Validasi theme
            if (is_null($data->theme_id) || !$data->theme) {
                session()->flash('message', 'Harap Pilih Tema Terlebih Dahulu!');
                return redirect()->back();
            }

            $preparedData = $this->prepareInvitationData($data, $tamu);

            return view($data->theme->path, $preparedData);
        } catch (ModelNotFoundException $e) {
            return abort(404, 'Undangan tidak ditemukan.');
        } catch (\Exception $e) {
            \Log::error('Error saat visit undangan: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan, silakan coba lagi.');
            return redirect()->back();
        }
    }

    protected function prepareInvitationData($data, $tamu = null)
    {
        // Pengambilan koleksi acara yang lebih handal
        $acara = $data->acara->get(1) ?? $data->acara->first();

        $thumbnailWa = $data->thumbnailWas;

        // Mencari tamu
        $ta = $data->tamu()->where('kode', $tamu)->first();

        $hari = [
            'Sunday'    => 'Minggu', 'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa', 'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',  'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $bulan = [
            'Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret',
            'Apr' => 'April',   'May' => 'Mei',      'Jun' => 'Juni',
            'Jul' => 'Juli',    'Aug' => 'Agustus',  'Sep' => 'September',
            'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember',
        ];

        $video = $data->galery->pluck('video')->filter()->toArray();
        $poto  = $data->galery->pluck('poto')->filter()->toArray();

        return [
            'data'        => $data,
            'hari'        => $hari,
            'bulan'       => $bulan,
            'tamu'        => $ta->nama ?? $tamu,
            'video'       => $video,
            'poto'        => $poto,
            'kode'        => $tamu,
            'ucapan'      => $data->ucapan,
            'acara'       => $acara,
            'thumbnailWa' => $thumbnailWa,
        ];
    }

    public function saveDoa(Request $request)
    {
        $va = $request->validate([
            'dataId' => 'required',
            'nama'   => 'required|string|max:20',
            'ucapan' => 'required|string|max:255',
            'status' => 'required|string|max:255'
        ], [
            'nama.required'   => 'Nama tidak boleh kosong.',
            'ucapan.required' => 'Ucapan tidak boleh kosong.',
            'ucapan.max'      => 'Ucapan tidak boleh lebih dari 255 karakter.',
            'status.required' => 'Pilih Kehadiran Kamu.',
        ]);

        // Cek fitur ucapan secara aman (null-safe)
        $fitur = FiturUcapan::where('data_id', $va['dataId'])->first();
        $isPublicActive = $fitur?->publicIsActive ?? false;

        // Cek tamu dengan scope spesifik ke data_id undangan agar aman
        $tamu = Tamu::where('data_id', $va['dataId'])
                    ->where('kode', $request->input('kode'))
                    ->first();

        $addTamu = null;

        if (!$tamu && !$isPublicActive) {
            session()->flash('message', 'Anda Tidak Masuk Dalam Daftar Tamu Yang Diundang.');
            return redirect()->back();
        } elseif (!$tamu && $isPublicActive) {
            $addTamu = Tamu::create([
                'data_id' => $va['dataId'],
                'kode'    => 0,
                'nama'    => $va['nama'],
                'slug'    => Str::slug($va['nama'])
            ]);
        }

        Ucapan::create([
            'data_id' => $va['dataId'],
            'tamu_id' => $tamu ? $tamu->id : $addTamu->id,
            'ucapan'  => $va['ucapan'],
            'status'  => $va['status']
        ]);

        return redirect()->back()->with('message', 'Ucapan doa berhasil dikirim');
    }
}
