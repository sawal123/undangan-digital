<?php

namespace App\Livewire\Dashboard\Kelola;

use App\Models\Data;
use App\Models\teksPenutup;
use Livewire\Component;
use App\Models\TeksUndangan;
use App\Models\teksWhatsApp;

class Setting extends Component
{
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

    public $pesanWa = '';


    public function mount()
    {
        $data = Data::find($this->dataId);
        $teksU = TeksUndangan::where('data_id', $this->dataId)->first();
        $pesan = teksWhatsApp::where('data_id', $this->dataId)->first();
        $turut = teksPenutup::where('data_id', $this->dataId)->first();
        if($turut){
            $this->hormatKami = $turut->hormat_kami;
            $this->turut = $turut->mengundang;
        }
        if ($pesan) {
            $this->pesanWa = $pesan->pesan;
            $this->pembuka = $teksU->pembuka;
            $this->acara = $teksU->acara;
            $this->penutup = $teksU->penutup;

        }
        $this->title = $data->title;
        $this->slug = $data->slug;

        // dd($this->title);
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
                'pesan' => "Kepada {{guest_name}}, Kami mengundang saudara/(i) untuk menghadiri acara pernikahan kami 
                *{{bride1_name}} & {{bride2_name}}*
                Pesan ini merupakan undangan resmi dari kami. Silahkan kunjungi link berikut untuk membuka undangan anda:
                {{guest_link}} 
                Atas kehadiran & doa restu dari saudara, kami ucapkan terimakasih."
            ]);
            session()->flash('teksWA', 'Teks WhatsApp Berhasil Dibuat.');
        }
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
                'pembuka' => "Kami mohon do'a & restunya atas pernikahan kami",
                'acara' => "Kami bermaksud untuk mengundang saudara/(i) dalam acara pernikahan kami pada:",
                'penutup' => "Atas kehadiran saudara/(i) & Do'a restunya, kami ucapkan terimakasih",
            ]);
            session()->flash('teksUndangan', 'Teks Undangan Berhasil Dibuat.');
        }
    }

    public function teksPenutup(){
        $teksP = teksPenutup::where('data_id', $this->dataId)->first();
        if($teksP){
            $teksP->update([
                'hormat_kami'=> $this->hormatKami,
                'mengundang'=> $this->turut,
            ]);
            session()->flash('teksPenutup', 'Teks Penutup Berhasil Diubah.');
        }else{
            teksPenutup::create([
                'data_id' => $this->dataId,
                'hormat_kami'=> $this->hormatKami,
                'mengundang'=> $this->turut,
            ]);
            session()->flash('teksPenutup', 'Teks Penutup Berhasil Dibuat.');
        }
    }

    public function render()
    {
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
