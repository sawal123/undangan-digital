<?php

namespace App\Livewire\Dashboard\Kelola;

use App\Models\Data;
use App\Models\KelolaUndangan\Qoute;
use Livewire\Component;
use App\Models\teksPenutup;
use App\Models\TeksUndangan;
use App\Models\teksWhatsApp;
use Illuminate\Support\Facades\Storage;
use App\Models\KelolaUndangan\ThumbnailWa;
use App\Models\Setting as ModelsSetting;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Setting extends Component
{
    use WithFileUploads;
    public $dataId;
    public $title;
    public $slug;
    public $pesan;
    public $button = false;


    public $pembuka = '';
    public $acara = '';
    public $penutup = '';

    public $hormatKami;
    public $turut;
    public $gambar; // File yang diupload
    public $pesanWa = '';
    public $tit = '';
    public $qoute = '';
    public $subtitle = '';

    public $titleAcara;

    public $thumbnail;


    public function titleA($id)
    {
        $setting = ModelsSetting::where('data_id', $id)->first();
        if ($setting) {
            $setting->update([
                'acara' => $this->titleAcara,
                'subacara' => '',
            ]);
        } else {
            ModelsSetting::create([
                'data_id'=>$id,
                'acara' => $this->titleAcara,
                'subacara' => '',
            ]);
        }
        session()->flash('title', 'Title Berhasil Di update');
    }

    public function mount()
    {
        error_reporting(0);
        $data = Data::find($this->dataId);
        $set = ModelsSetting::where('data_id', $this->dataId)->first();
        $teksU = TeksUndangan::where('data_id', $this->dataId)->first();
        $pesan = teksWhatsApp::where('data_id', $this->dataId)->first();
        $turut = teksPenutup::where('data_id', $this->dataId)->first();
        $qoute = Qoute::where('data_id', $this->dataId)->first();
        // $this->dataId = $dataId;
        $this->loadThumbnail();
        if ($turut) {
            $this->hormatKami = $turut->hormat_kami;
            $this->turut = $turut->mengundang;
        }
        if ($pesan) {
            $this->pesanWa = $pesan->pesan;
            $this->pembuka = $teksU->pembuka;
            $this->acara = $teksU->acara;
            $this->penutup = $teksU->penutup;
        }
        $this->tit = $qoute->title;
        $this->titleAcara = $set->acara;
        $this->qoute = $qoute->qoute;
        $this->subtitle = $qoute->subtitle;
        $this->title = $data->title;
        $this->slug = $data->slug;

        // dd($this->title);
    }

    public function aksiQoute()
    {
        $qoute = Qoute::where('data_id', $this->dataId)->first();
        if ($qoute) {
            $qoute->update([
                'title' => $this->tit,
                'qoute' => $this->qoute,
                'subtitle' => $this->subtitle
            ]);
        } else {
            Qoute::create([
                'data_id' => $this->dataId,
                'title' => $this->tit,
                'qoute' => $this->qoute,
                'subtitle' => $this->subtitle
            ]);
        }

        session()->flash('messageQoute', 'Qoute Berhasil Di update');
    }

    public function update($id)
    {
        $data = Data::find($id);
        $data->update([
            'title' => $this->title,
            'slug' => $this->slug
        ]);
        session()->flash('title', 'Data Undangan Berhasil Di update');
    }

    public function teksWhatsApp()
    {
        $wa  = teksWhatsApp::where('data_id', $this->dataId)->first();
        if ($wa) {
            $wa->update([
                'data_id' => $this->dataId,
                'pesan' => $this->pesanWa,
            ]);
            session()->flash('teksWA', 'Teks WhatsApp Berhasil Diupdate.');
        } else {
            teksWhatsApp::create([
                'data_id' => $this->dataId,
                'pesan' => "
               Kepada {{tamu}}, Kami mengundang saudara/(i) untuk menghadiri acara pernikahan kami 
{{nama_mempelai1}} & {{nama_mempelai2}}
Pesan ini merupakan undangan resmi dari kami. Silahkan kunjungi link berikut untuk membuka undangan anda:
{{link }} 
Atas kehadiran & doa restu dari saudara, kami ucapkan terimakasih."
            ]);
            session()->flash('teksWA', 'Teks WhatsApp Berhasil Dibuat.');
        }
    }
    public function loadThumbnail()
    {
        $this->thumbnail = ThumbnailWa::where('data_id', $this->dataId)->first();
        $this->gambar = null;
    }

    public function delThumbnail()
    {
        $thumbnail = ThumbnailWa::where('data_id', $this->dataId)->first();

        if ($thumbnail) {
            // Hapus file dari storage
            Storage::delete('public/' . $thumbnail->thumbnail);
            $thumbnail->delete();

            // Set feedback ke user
            session()->flash('thumbnailWa', 'Gambar berhasil dihapus.');

            // Refresh thumbnail
            $this->loadThumbnail();
        } else {
            session()->flash('thumbnailWa', 'Data tidak ditemukan.');
        }
    }

    public function thumbnailWa()
    {
        // Validasi file
        $this->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:1024',
        ]);
        // Ambil thumbnail dari database
        $data = ThumbnailWa::where('data_id', $this->dataId)->first();
        // Upload file baru
        $imagePath = $this->gambar->store('thumbnailwa', 'public');
        if ($data) {
            // Hapus file lama jika ada
            if ($data->thumbnail) {
                Storage::delete('public/' . $data->thumbnail);
            }
            // Perbarui data thumbnail
            $data->update(['thumbnail' => $imagePath]);
        } else {
            // Simpan data thumbnail baru
            ThumbnailWa::create([
                'data_id' => $this->dataId,
                'thumbnail' => $imagePath,
            ]);
        }
        // Set feedback ke user
        session()->flash('thumbnailWa', 'Gambar berhasil diupload.');
        // Refresh thumbnail
        $this->loadThumbnail();
    }


    public function TeksUndangan()
    {
        $teksU = TeksUndangan::where('data_id', $this->dataId)->first();
        if ($teksU) {
            $teksU->update([
                'pembuka' => $this->pembuka,
                'acara' => $this->acara,
                'penutup' => $this->penutup
            ]);
            session()->flash('teksUndangan', 'Teks Undangan Berhasil Diupdate.');
        } else {
            TeksUndangan::create([
                'data_id' => $this->dataId,
                'pembuka' => "بسم الله الرحمن الرحيم
                Kami mohon do'a & restunya atas pernikahan kami",
                'acara' => "Kami bermaksud untuk mengundang saudara/(i) dalam acara pernikahan kami pada:",
                'penutup' => "Atas kehadiran saudara/(i) & Do'a restunya, kami ucapkan terimakasih",
            ]);
            session()->flash('teksUndangan', 'Teks Undangan Berhasil Dibuat.');
        }
    }

    public function teksPenutup()
    {
        $teksP = teksPenutup::where('data_id', $this->dataId)->first();
        if ($teksP) {
            $teksP->update([
                'hormat_kami' => $this->hormatKami,
                'mengundang' => $this->turut,
            ]);
            session()->flash('teksPenutup', 'Teks Penutup Berhasil Diubah.');
        } else {
            teksPenutup::create([
                'data_id' => $this->dataId,
                'hormat_kami' => $this->hormatKami,
                'mengundang' => $this->turut,
            ]);
            session()->flash('teksPenutup', 'Teks Penutup Berhasil Dibuat.');
        }
    }

    public function render()
    {
        $this->thumbnail = ThumbnailWa::where('data_id', $this->dataId)->first();
        if (!$this->thumbnail) {
            $this->thumbnail = null;
        }
        $dSlug = Data::where('slug', $this->slug)->first();
        if ($dSlug) {
            if ($dSlug->id === $this->dataId) {
                $this->pesan = "";
                $this->button = true;
            } else {
                $this->pesan = "Slug " . $this->slug . " Sudah Digunakan Orang Lain";
                $this->button = false;
            }
        } else {
            $this->pesan = "Slug " . $this->slug . " Bisa digunakan!";
            $this->button = true;
        }
        return view('livewire.dashboard.kelola.setting');
    }
}
