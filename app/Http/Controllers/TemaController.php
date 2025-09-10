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
        $tema = Crypt::decryptString($demo);
        $id = Crypt::decryptString($id);
        return view($tema);
    }
    public function temademo($demo)
    {
        return view($demo);
    }
    public function visit($slug, $tamu = null)
    {
        error_reporting(0);
        try {
            $data = Data::where('slug', $slug)->firstOrFail();

            // Pilih acara, default ke index 0 kalau index 1 nggak ada
            $acara = $data->acara[1] ?? $data->acara[0] ?? null;

            // Ambil thumbnail WhatsApp
            $thumbnailWa = ThumbnailWa::where('data_id', $data->id)->first();

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
            $ucapan = Ucapan::where('data_id', $data->id)->get();

            // Validasi theme
            if (is_null($data->theme_id) || !$data->theme) {
                session()->flash('message', 'Harap Pilih Tema Terlebih Dahulu!');
                return redirect()->back();
            }

            return view($data->theme->path, [
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
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Kalau slug tidak ditemukan
            return abort(404, 'Undangan tidak ditemukan.');
        } catch (\Exception $e) {
            // Catch all error lain
            \Log::error('Error saat visit undangan: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan, silakan coba lagi.');
            return redirect()->back();
        }
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
