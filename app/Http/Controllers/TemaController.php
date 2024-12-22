<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;
use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\Galery;
use App\Models\KelolaUndangan\Ucapan;
use Illuminate\Support\Facades\Crypt;
use App\Models\KelolaUndangan\FiturUcapan;

class TemaController extends Controller
{
    protected function getData($id)
    {
        return $tema = Crypt::decryptString($id);
    }
    public function index($slug)
    {
        dd('tes');
        $tema = Data::where('slug', $slug)->first();
        return $tema;
    }
    public function demo($demo, $id)
    {
        error_reporting(0);
        $tema = Crypt::decryptString($demo);
        $id = Crypt::decryptString($id);
        return view($tema);
    }
    public function visit($slug, $tamu = null)
    {
        error_reporting(0);

        $data = Data::where('slug', $slug)->first();
        $ta = $data->tamu()->where('kode', $tamu)->first();
        $hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
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
        $gallery = Galery::all();
        foreach ($gallery as $ga) {
            if ($ga->video) {
                $video[] = $ga->video;
            }
        }
        foreach ($gallery as $po) {
            if ($po->poto) {
                $poto[] = $po->poto;
            }
        }

        $ucapan = Ucapan::where('data_id', $data->id)->get();


        if ($data->theme_id === null) {
            session()->flash('message', 'Harap Pilih Tema Terlebih Dahulu!');
            return redirect()->back();
        } else {
            return view($data->theme->path, [
                'data' => $data,
                'hari' => $hari,
                'bulan' => $bulan,
                'tamu' => $ta ? $ta->nama : $tamu,
                'video' => $video,
                'poto' => $poto,
                'kode' => $tamu,
                'ucapan' => $ucapan
            ]);
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
