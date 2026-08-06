<?php

namespace App\Livewire\DashboardDemo\Kelola;

use App\Livewire\DashboardDemo\Kelola\Concerns\LoadsOwnedInvitation;
use App\Models\Data;
use App\Models\DataFonts;
use App\Models\Fonts;
use App\Models\KelolaUndangan\Qoute;
use App\Models\KelolaUndangan\ThumbnailWa;
use App\Models\Setting as ModelsSetting;
use App\Models\teksPenutup;
use App\Models\TeksUndangan;
use App\Models\teksWhatsApp;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Setting extends Component
{
    use LoadsOwnedInvitation;
    use WithFileUploads;

    #[Locked]
    public $dataId;

    public $title;

    public $slug;

    public $pesan;

    public $button = false;

    public $fontTitle;

    public $fontPara;

    public $sizeTitle = 32;

    public $sizePara = 16;

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

    public function titleA($id): void
    {
        $this->authorizeInvitationState();
        $setting = ModelsSetting::where('data_id', $this->dataId)->first();
        if ($setting) {
            $setting->update([
                'acara' => $this->titleAcara,
                'subacara' => '',
            ]);
        } else {
            ModelsSetting::create([
                'data_id' => $this->dataId,
                'acara' => $this->titleAcara,
                'subacara' => '',
            ]);
        }
        session()->flash('title', 'Title Berhasil Di update');
    }

    public function mount(string $id): void
    {
        $data = $this->ownedInvitationByUid($id, ['dataFont.titleFont', 'dataFont.subFont']);
        $this->dataId = $data->id;

        if (! $data) {
            return;
        }

        $set = ModelsSetting::where('data_id', $this->dataId)->first();
        $teksU = TeksUndangan::where('data_id', $this->dataId)->first();
        $pesan = teksWhatsApp::where('data_id', $this->dataId)->first();
        $turut = teksPenutup::where('data_id', $this->dataId)->first();
        $qoute = Qoute::where('data_id', $this->dataId)->first();

        if ($data->dataFont) {
            $this->fontTitle = $data->dataFont->f_title ?? null;
            $this->fontPara = $data->dataFont->f_sub ?? null;
            $this->sizeTitle = $data->dataFont->s_title ?? 32;
            $this->sizePara = $data->dataFont->s_sub ?? 16;
        }

        $defaultFontId = Fonts::where('is_active', 1)->value('id');
        $this->fontTitle = $this->fontTitle ?: $defaultFontId;
        $this->fontPara = $this->fontPara ?: $defaultFontId;

        $this->loadThumbnail();

        if ($turut) {
            $this->hormatKami = $turut->hormat_kami;
            $this->turut = $turut->mengundang;
        }

        if ($pesan) {
            $this->pesanWa = $pesan->pesan;
        }

        if ($teksU) {
            $this->pembuka = $teksU->pembuka;
            $this->acara = $teksU->acara;
            $this->penutup = $teksU->penutup;
        }

        if ($qoute) {
            $this->tit = $this->normalizeArabicText($qoute->title);
            $this->qoute = $this->normalizeArabicText($qoute->qoute);
            $this->subtitle = $this->normalizeArabicText($qoute->subtitle);
        }

        if ($set) {
            $this->titleAcara = $set->acara;
        }

        $this->title = $data->title;
        $this->slug = $data->slug;
    }

    public function aksiQoute(): void
    {
        $this->authorizeInvitationState();
        $this->tit = $this->normalizeArabicText($this->tit);
        $this->qoute = $this->normalizeArabicText($this->qoute);
        $this->subtitle = $this->normalizeArabicText($this->subtitle);

        $qoute = Qoute::where('data_id', $this->dataId)->first();
        if ($qoute) {
            $qoute->update([
                'title' => $this->tit,
                'qoute' => $this->qoute,
                'subtitle' => $this->subtitle,
            ]);
        } else {
            Qoute::create([
                'data_id' => $this->dataId,
                'title' => $this->tit,
                'qoute' => $this->qoute,
                'subtitle' => $this->subtitle,
            ]);
        }

        session()->flash('messageQoute', 'Qoute Berhasil Di update');
    }

    private function normalizeArabicText(?string $value): ?string
    {
        if ($value === null || $value === '' || ! preg_match('/[ØÙÛ]/u', $value)) {
            return $value;
        }

        foreach (['Windows-1252', 'ISO-8859-1'] as $encoding) {
            $bytes = @iconv('UTF-8', $encoding.'//IGNORE', $value);
            if ($bytes === false) {
                continue;
            }

            $fixed = @iconv('UTF-8', 'UTF-8//IGNORE', $bytes);
            if ($fixed !== false && preg_match('/\p{Arabic}/u', $fixed)) {
                return $fixed;
            }
        }

        return $value;
    }

    public function update($id): void
    {
        $this->slug = Str::slug($this->slug);
        $this->validate([
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('data', 'slug')->ignore($this->dataId)],
        ]);

        $data = $this->ownedInvitationById($this->dataId);
        $data->update([
            'title' => $this->title,
            'slug' => $this->slug,
        ]);
        session()->flash('title', 'Data Undangan Berhasil Di update');
    }

    public function teksWhatsApp(): void
    {
        $this->authorizeInvitationState();
        $wa = teksWhatsApp::where('data_id', $this->dataId)->first();
        if ($wa) {
            $wa->update([
                'data_id' => $this->dataId,
                'pesan' => $this->pesanWa,
            ]);
            session()->flash('teksWA', 'Teks WhatsApp Berhasil Diupdate.');
        } else {
            teksWhatsApp::create([
                'data_id' => $this->dataId,
                'pesan' => 'Kepada {{tamu}}, Kami mengundang saudara/(i) untuk menghadiri acara pernikahan kami
{{nama_mempelai1}} & {{nama_mempelai2}}
Pesan ini merupakan undangan resmi dari kami. Silahkan kunjungi link berikut untuk membuka undangan anda:
{{link}}
Atas kehadiran & doa restu dari saudara, kami ucapkan terimakasih.',
            ]);
            session()->flash('teksWA', 'Teks WhatsApp Berhasil Dibuat.');
        }
    }

    public function loadThumbnail(): void
    {
        $this->authorizeInvitationState();
        $this->thumbnail = ThumbnailWa::where('data_id', $this->dataId)->first();
        $this->gambar = null;
    }

    public function delThumbnail(): void
    {
        $this->authorizeInvitationState();
        $thumbnail = ThumbnailWa::where('data_id', $this->dataId)->first();

        if ($thumbnail) {
            // Hapus file dari storage
            Storage::delete('public/'.$thumbnail->thumbnail);
            $thumbnail->delete();

            // Set feedback ke user
            session()->flash('thumbnailWa', 'Gambar berhasil dihapus.');

            // Refresh thumbnail
            $this->loadThumbnail();
        } else {
            session()->flash('thumbnailWa', 'Data tidak ditemukan.');
        }
    }

    public function thumbnailWa(): void
    {
        $this->authorizeInvitationState();
        // Validasi file
        $this->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        // Ambil thumbnail dari database
        $data = ThumbnailWa::where('data_id', $this->dataId)->first();
        // Upload file baru
        $imagePath = $this->gambar->store('thumbnailwa', 'public');
        if ($data) {
            // Hapus file lama jika ada
            if ($data->thumbnail) {
                Storage::delete('public/'.$data->thumbnail);
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

    public function TeksUndangan(): void
    {
        $this->authorizeInvitationState();
        $teksU = TeksUndangan::where('data_id', $this->dataId)->first();
        if ($teksU) {
            $teksU->update([
                'pembuka' => $this->pembuka,
                'acara' => $this->acara,
                'penutup' => $this->penutup,
            ]);
            session()->flash('teksUndangan', 'Teks Undangan Berhasil Diupdate.');
        } else {
            TeksUndangan::create([
                'data_id' => $this->dataId,
                'pembuka' => "بسم الله الرحمن الرحيم
                Kami mohon do'a & restunya atas pernikahan kami",
                'acara' => 'Kami bermaksud untuk mengundang saudara/(i) dalam acara pernikahan kami pada:',
                'penutup' => "Atas kehadiran saudara/(i) & Do'a restunya, kami ucapkan terimakasih",
            ]);
            session()->flash('teksUndangan', 'Teks Undangan Berhasil Dibuat.');
        }
    }

    public function teksPenutup(): void
    {
        $this->authorizeInvitationState();
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

    public function updateFont($id): void
    {
        $data = $this->ownedInvitationById($this->dataId, ['dataFont']);
        if ($data->dataFont) {
            $font = $data->dataFont->update([
                'f_title' => $this->fontTitle,
                'f_sub' => $this->fontPara,
                's_title' => $this->sizeTitle,
                's_sub' => $this->sizePara,
            ]);
        } else {
            $font = DataFonts::create([
                'data_id' => $this->dataId,
                'f_title' => $this->fontTitle,
                'f_sub' => $this->fontPara,
                's_title' => $this->sizeTitle,
                's_sub' => $this->sizePara,
            ]);
        }
        session()->flash('font', 'Font Berhasil Diubah');
    }

    public function updatedSlug(): void
    {
        $this->authorizeInvitationState();
        
        $dSlug = Data::where('slug', $this->slug)
            ->whereKeyNot($this->dataId)
            ->exists();
        
        if ($dSlug) {
            $this->pesan = 'Slug '.$this->slug.' Sudah Digunakan Orang Lain';
            $this->button = false;
        } else {
            $this->pesan = 'Slug '.$this->slug.' Bisa digunakan!';
            $this->button = true;
        }
    }

    public function render()
    {
        $this->authorizeInvitationState();

        $selectedFont = null;
        if ($this->fontTitle) {
            $selectedFont = Fonts::firstWhere('id', $this->fontTitle);
        }
        $selectedPara = null;
        if ($this->fontPara) {
            $selectedPara = Fonts::firstWhere('id', $this->fontPara);
        }
        $this->thumbnail = ThumbnailWa::where('data_id', $this->dataId)->first();
        if (! $this->thumbnail) {
            $this->thumbnail = null;
        }

        $fonts = Fonts::where('is_active', 1)->get();

        return view(
            'livewire.dashboard.kelola.setting',
            [
                'fonts' => $fonts,
                'selectedFont' => $selectedFont,
                'selectedPara' => $selectedPara,
            ]
        )->layout('components.layouts.user-new', [
            'headerTitle' => 'Pengaturan',
        ]);
    }
}
