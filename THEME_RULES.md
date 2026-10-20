# THEME_RULES.md

> Kontrak teknis untuk membuat, menambah, atau memigrasikan tema pada repository `sawal123/undangan-digital`.
>
> File ini **wajib dibaca setelah `AGENTS.md`**. `AGENTS.md` mengatur cara kerja umum agent, sedangkan file ini mengatur kontrak khusus tema.

---

## 1. Cara Memanggil Agent

Prompt pekerjaan tema sebaiknya selalu dimulai dengan:

```text
Ikuti seluruh aturan di AGENTS.md.
Untuk pekerjaan tema, ikuti juga seluruh aturan di THEME_RULES.md.
```

Urutan prioritas aturan:

1. `AGENTS.md`
2. `THEME_RULES.md`
3. Prompt task yang sedang dikerjakan

Jika prompt task lebih sempit daripada file ini, ikuti scope task yang lebih sempit.

---

# 2. Tujuan Utama Tema

Tema production harus:

- memakai data undangan dari backend, bukan data hardcoded;
- tetap render ketika data minimal/partial;
- responsive di mobile, tablet, dan desktop;
- mendukung fitur project yang relevan dengan jenis undangan;
- memakai shared music player;
- memakai shared social-preview metadata;
- menampilkan seluruh gallery photo yang tersedia;
- tidak membuat query database baru dari Blade;
- tidak menggandakan business logic yang sudah berada di controller/service;
- tidak merusak tema lain.

**Production theme bukan static HTML demo.**

Static demo boleh memiliki data contoh, tetapi production theme harus memakai variable dari aplikasi.

---

# 3. Struktur Folder

Gunakan namespace asset per-theme agar tidak bentrok dengan theme lain.

Contoh:

```text
resources/
└── views/
    ├── tema/
    │   └── nama-theme/
    │       ├── nama-theme.blade.php
    │       ├── cover.blade.php
    │       ├── content/
    │       └── ...
    └── temademo/
        └── nama-theme.blade.php

public/
└── tema/
    └── nama-theme/
        ├── css/
        ├── js/
        ├── images/
        └── assets/
```

Tidak wajib memecah Blade menjadi banyak partial jika theme kecil.

Jangan membuat struktur rumit jika satu file Blade masih lebih jelas.

---

# 4. Registrasi Theme

Model `Theme` memakai field:

| Field | Fungsi |
|---|---|
| `nama` | Nama theme di admin |
| `category_id` | Kategori theme |
| `event_type_id` | Jenis undangan |
| `path` | View production |
| `demo` | View demo statis |
| `thumbnail` | Thumbnail katalog theme |

Contoh production path:

```text
tema.flowerone.flowerone
tema.wedding_blue
tema.spiderman.ultah-induk
```

## Aturan `path`

`path` harus:

- benar-benar ada sebagai Blade view;
- menunjuk ke namespace `tema.*`;
- merupakan production theme.

## Aturan `demo`

Jika memakai demo:

```text
temademo.nama-theme
```

`demo`:

- harus berada di namespace `temademo.*`;
- harus benar-benar ada;
- jangan menunjuk ke `tema.*`.

Jika tidak membutuhkan demo statis, `demo` boleh kosong sesuai flow admin.

---

# 5. Jenis Event yang Tersedia

Current event type:

| Key | Nama |
|---|---|
| `wedding` | Pernikahan |
| `birthday` | Ulang Tahun |
| `engagement` | Tunangan |
| `pengajian` | Pengajian |
| `event` | Event umum |

## Prinsip Penting

Jangan memaksakan data wedding ke semua jenis event.

### Wedding

Gunakan:

```php
$data->pria
$data->wanita
```

### Birthday

Gunakan:

```php
$data->birthdayProfile
```

dan bila relevan:

```php
$data->eventDetail
```

**Jangan membuat birthday theme menampilkan dua profile pria/wanita.**

### Engagement / Pengajian / Event

Jangan menebak struktur UI.

Sebelum membuat theme untuk ketiga event type ini:

1. cek editor/Livewire yang mengisi datanya;
2. cek relation yang benar-benar tersedia;
3. gunakan `eventDetail` atau relation lain hanya jika memang diisi oleh flow tersebut.

Jangan membuat field database baru hanya agar theme bisa selesai.

---

# 6. View Variables dari `TemaController`

Production theme dirender melalui `TemaController`.

Variable berikut tersedia langsung di view:

| Variable | Isi |
|---|---|
| `$data` | Object `Data` beserta relation yang sudah eager-loaded |
| `$hari` | Mapping hari Inggris → Indonesia |
| `$bulan` | Mapping bulan Inggris → Indonesia |
| `$tamu` | Nama tamu hasil resolve URL, fallback `Tamu Undangan` |
| `$video` | Array URL video dari gallery, sudah `filter()->values()` |
| `$poto` | Array path foto gallery, sudah `filter()->values()` |
| `$kode` | Kode tamu dari URL |
| `$ucapan` | Collection ucapan terbaru beserta relation tamu |
| `$acara` | Acara terpilih dari controller |
| `$thumbnailWa` | Relation thumbnail WhatsApp/social preview |

## Catatan `$acara`

Jangan berasumsi `$acara` selalu acara pertama.

Current controller memilih:

- item index `1` jika tersedia;
- jika tidak, fallback ke acara pertama.

Jika theme perlu menampilkan **semua acara**, gunakan:

```php
$data->acara
```

dengan loop.

---

# 7. Base Data

Field utama `$data`:

```php
$data->title
$data->slug
$data->uid
$data->isActive
$data->theme
$data->eventType
```

Theme tidak perlu melakukan pengecekan premium/shareability sendiri.

`TemaController` sudah menangani akses public sebelum theme dirender.

Jangan menambahkan query seperti:

```php
Data::find(...)
Pria::where(...)
Galery::where(...)
```

di Blade.

Gunakan relation yang sudah tersedia.

---

# 8. Relationship Contract

`$data` sudah eager-load relation berikut:

```php
$data->theme
$data->eventType
$data->pria
$data->wanita
$data->birthdayProfile
$data->eventDetail
$data->acara
$data->galery
$data->sound
$data->FiturUcapan
$data->streaming
$data->kado
$data->kado->giftPay
$data->fiturKado
$data->imageKisah
$data->kisah
$data->kisah->image
$data->dataFont
$data->dataFont->titleFont
$data->dataFont->subFont
$data->thumbnailWas
$data->teksUndangan
$data->coverUndangan
$data->setting
$data->qoute
$data->teksPenutup
$data->ucapan
$data->ucapan->tamu
```

Semua relation harus dianggap **optional/null-safe** kecuali task secara eksplisit mengatakan sebaliknya.

---

# 9. Wedding Profile Variables

## Pria

```php
$data->pria?->nama_lengkap
$data->pria?->nama_panggilan
$data->pria?->deskripsi
$data->pria?->image
```

## Wanita

```php
$data->wanita?->nama_lengkap
$data->wanita?->nama_panggilan
$data->wanita?->deskripsi
$data->wanita?->image
```

## Aturan Wedding

Jika kedua profile tersedia:

- tampilkan pria;
- tampilkan wanita;
- gunakan image masing-masing;
- jangan memakai foto pria untuk wanita;
- jangan memakai gallery sebagai pengganti profile jika image profile tersedia;
- gunakan `object-fit: cover` / `object-cover`;
- jangan membuat foto gepeng.

Contoh:

```blade
@if ($data->pria?->image)
    <img
        src="{{ asset('storage/' . ltrim($data->pria->image, '/')) }}"
        alt="{{ $data->pria->nama_lengkap ?? 'Mempelai pria' }}"
        class="object-cover"
    >
@endif
```

Gunakan pola null-safe yang sama untuk wanita.

---

# 10. Birthday Profile Variables

```php
$data->birthdayProfile?->name
$data->birthdayProfile?->nickname
$data->birthdayProfile?->age
$data->birthdayProfile?->parent_name
$data->birthdayProfile?->description
$data->birthdayProfile?->photo
```

Birthday theme menggunakan **satu profile utama**.

Jangan memaksakan:

```php
$data->pria
$data->wanita
```

ke birthday theme.

---

# 11. Event Detail Variables

Generic event detail:

```php
$data->eventDetail?->headline
$data->eventDetail?->host_name
$data->eventDetail?->speaker_name
$data->eventDetail?->dress_code
$data->eventDetail?->description
$data->eventDetail?->image
```

Semua harus null-safe.

---

# 12. Acara Variables

`$data->acara` merupakan collection.

Setiap item memiliki:

```php
$item->nama_acara
$item->vanue
$item->alamat
$item->date
$item->jam_start
$item->jam_end
$item->zona_waktu
$item->maps
```

> Catatan: field existing bernama `vanue`. Jangan diam-diam menggantinya menjadi `venue`.

## Aturan Acara

Untuk menampilkan semua acara:

```blade
@foreach ($data->acara ?? collect() as $event)
    ...
@endforeach
```

Pastikan:

- tanggal null tidak membuat `Carbon::parse()` crash;
- `jam_end` dapat berupa jam maupun teks seperti `Selesai`;
- `maps` boleh null;
- link maps hanya dirender jika URL tersedia.

---

# 13. Cover Images

Relation:

```php
$data->coverUndangan?->cover_satu
$data->coverUndangan?->cover_dua
```

Untuk cover/hero production, prioritaskan cover image yang memang disediakan user.

Contoh helper lokal:

```blade
@php
    $storageUrl = fn ($path) =>
        $path ? asset('storage/' . ltrim($path, '/')) : null;
@endphp
```

Jangan mencampur empat jenis image ini:

| Jenis | Sumber |
|---|---|
| Cover undangan | `$data->coverUndangan` |
| Profile pasangan | `$data->pria` / `$data->wanita` |
| Birthday profile | `$data->birthdayProfile` |
| Gallery | `$poto` |
| Social/WhatsApp thumbnail | `$data->thumbnailWas` |
| Theme catalog thumbnail | `Theme.thumbnail` |

`thumbnailWas` adalah social/share thumbnail. Jangan otomatis menjadikannya hero utama theme baru.

---

# 14. Invitation Text

```php
$data->teksUndangan?->pembuka
$data->teksUndangan?->acara
$data->teksUndangan?->penutup
```

Render sebagai dynamic text.

Jangan menyalin teks contoh menjadi hardcoded production content jika field tersedia.

---

# 15. Quote

```php
$data->qoute?->title
$data->qoute?->qoute
$data->qoute?->subtitle
```

Semua optional.

Jangan mengubah encoding/Arabic text di theme.

Normalization dilakukan di backend/editor.

---

# 16. Closing Text

```php
$data->teksPenutup?->hormat_kami
$data->teksPenutup?->mengundang
```

Jangan hardcode keluarga jika data tersedia.

---

# 17. Setting / Heading Acara

Field yang saat ini digunakan theme:

```php
$data->setting?->acara
$data->setting?->subacara
```

Gunakan fallback visual bila null.

Contoh:

```blade
{{ $data->setting?->acara ?? 'The Wedding' }}
```

Fallback hanya untuk tampilan, bukan untuk menulis data baru ke database.

---

# 18. Gallery Photo

Gunakan array:

```php
$poto
```

yang sudah dinormalisasi controller.

## Wajib

Gallery harus mendukung:

- 0 foto;
- 1 foto;
- 2 foto;
- lebih dari 2 foto.

Gunakan:

```blade
@forelse ($poto ?? [] as $item)
    <img
        src="{{ asset('storage/' . ltrim($item, '/')) }}"
        alt="Gallery"
    >
@empty
    {{-- optional empty state / tidak render section --}}
@endforelse
```

## Dilarang

Jangan:

```php
$poto[0]
$poto[1]
array_slice($poto, 0, 2)
```

jika hasilnya membuat foto lain tidak pernah dirender.

Layout boleh:

- grid;
- masonry;
- swiper;
- featured + thumbnails;
- even/odd split.

Tetapi **seluruh foto harus tetap dapat dirender/diakses**.

---

# 19. Gallery Video

Gunakan:

```php
$video
```

`$video` berisi URL video.

Jangan merender URL video menggunakan `<img>`.

Gunakan iframe/player sesuai format existing theme.

Jangan menganggap `$video` adalah path storage image.

---

# 20. Love Story / Kisah

Collection:

```php
$data->kisah
```

Per item:

```php
$story->title
$story->deskripsi
$story->image?->image
```

Juga tersedia:

```php
$data->imageKisah
```

Gunakan relation existing sesuai pola theme.

Jangan membuat query tambahan untuk mengambil image kisah.

Untuk event type yang tidak membutuhkan love story, section boleh tidak digunakan.

---

# 21. Music — Wajib Pakai Core Player

**Jangan membuat engine musik sendiri untuk theme baru.**

Gunakan:

```blade
@include('tema.partials.music', ['data' => $data])
```

Core player membaca:

```php
$data->sound?->sound
$data->sound?->start
$data->sound?->isActive
```

Field Sound:

| Field | Fungsi |
|---|---|
| `sound` | YouTube URL, direct HTTP audio, atau local storage path |
| `start` | Detik awal |
| `isActive` | Status music |

Core player sudah menangani:

- YouTube raw/watch/embed;
- normalisasi YouTube;
- start time;
- direct HTTP audio;
- local audio;
- pause/play;
- resume;
- loop audio.

## Music Button

Jika theme memiliki tombol music:

```html
<button id="musicToggle" ...>
    <i class="fa-solid fa-music"></i>
</button>
```

Core player mengenali:

```text
id="musicToggle"
```

## Open Cover → Play

Jika existing design memulai musik setelah cover dibuka:

```js
window.musicPlayer?.play();
```

Untuk pause:

```js
window.musicPlayer?.pause();
```

## Dilarang

Jangan:

- hardcode URL YouTube;
- hardcode video ID;
- menyusun `?start=` manual;
- manipulasi iframe `src` untuk play/pause;
- membuat `videoFrame` player kedua;
- membuat audio player kedua;
- menggandakan music state engine.

### Icon Custom

Core default menggunakan state:

```text
fa-music
fa-pause
```

Jika theme ingin icon paused `fa-play`, buat adaptor kecil **di layer theme**.

Jangan ubah core hanya untuk satu theme.

Pastikan tidak pernah ada:

```text
fa-play fa-pause
```

bersamaan pada icon yang sama.

---

# 22. Streaming

```php
$data->streaming?->link
$data->streaming?->isActive
```

Render hanya jika aktif dan link tersedia.

Contoh kondisi:

```blade
@if ($data->streaming?->isActive && $data->streaming?->link)
    ...
@endif
```

Jangan hardcode link live stream.

---

# 23. Gift / Kado

Feature flag:

```php
$data->fiturKado?->isActive
```

Collection:

```php
$data->kado
```

Per item:

```php
$gift->gift_id
$gift->namaPay
$gift->nomorPay
$gift->qris
$gift->giftPay?->nama_pay
$gift->giftPay?->icon
```

## Aturan

- section hanya aktif jika fitur kado aktif;
- loop seluruh rekening/payment method;
- `qris` optional;
- jangan expose data jika feature disabled;
- jangan hardcode rekening.

---

# 24. RSVP / Ucapan

Feature config:

```php
$data->FiturUcapan?->isActive
$data->FiturUcapan?->publicIsActive
$data->FiturUcapan?->viewIsActive
```

## Arti

- `isActive`: fitur ucapan/RSVP aktif;
- `publicIsActive`: tamu di luar daftar boleh mengirim; nama wajib diisi;
- `viewIsActive`: kontrol tampilan daftar ucapan.

Variable:

```php
$tamu
$kode
$ucapan
```

## Endpoint

Jangan membuat endpoint baru.

Gunakan route existing:

```blade
route('savedoa')
```

Payload yang didukung controller:

```text
dataId
nama
ucapan
status
kode
```

Contoh dasar:

```blade
<form method="POST" action="{{ route('savedoa') }}">
    @csrf

    <input type="hidden" name="dataId" value="{{ $data->id }}">
    <input type="hidden" name="kode" value="{{ $kode }}">

    <input type="text" name="nama">
    <textarea name="ucapan"></textarea>

    <select name="status">
        <option value="hadir">Hadir</option>
        <option value="tidak_hadir">Tidak Hadir</option>
        <option value="ragu">Ragu</option>
    </select>

    <button type="submit">Kirim</button>
</form>
```

Status backend dinormalisasi.

Jangan menambah status baru dari theme tanpa perubahan backend yang memang diminta.

---

# 25. Guest Name

Gunakan:

```php
$tamu
```

untuk sapaan cover.

Contoh:

```blade
<p>Kepada Yth.</p>
<h3>{{ $tamu ?? 'Tamu Undangan' }}</h3>
```

Jangan membaca kode tamu dari query/database sendiri.

---

# 26. Social Preview / WhatsApp

Semua production theme wajib memakai shared component:

```blade
@include('components.social-preview-meta', [
    'data' => $data,
    'title' => $data->title ?? $pageTitle ?? 'WayaeNikah',
])
```

## Theme tetap wajib menyediakan metadata dasar

Component social preview saat ini fokus pada image/Twitter metadata.

Di `<head>` tetap sediakan:

```blade
<meta property="og:site_name" content="Wayae Nikah">
<meta property="og:title" content="{{ $data->title ?? $pageTitle ?? 'WayaeNikah' }}">
<meta property="og:description" content="...">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">

@include('components.social-preview-meta', [
    'data' => $data,
    'title' => $data->title ?? $pageTitle ?? 'WayaeNikah',
])
```

## Dilarang

Jangan membuat lagi:

```blade
<meta property="og:image" content="{{ url('storage/' . ($data->thumbnailWas?->thumbnail ?? '')) }}">
```

karena thumbnail null dapat menghasilkan broken `/storage/`.

Jangan duplicate `og:image` di theme setelah include shared component.

## WhatsApp Image Rule

Project rule untuk thumbnail social preview:

- target file akhir **< 500 KB**;
- gunakan JPG/PNG yang benar-benar sesuai MIME;
- jangan menyimpan JPEG binary dengan extension `.png`;
- thumbnail harus bisa diakses guest tanpa auth;
- URL harus HTTPS absolute.

Jika masalah preview terjadi, jangan langsung mengubah theme. Cek:

1. `og:image`;
2. image URL direct;
3. HTTP 200;
4. MIME;
5. ukuran file;
6. storage symlink;
7. WAF/rate limit.

---

# 27. SEO / Privacy

Default production invitation sebaiknya mengikuti policy existing:

```html
<meta name="robots" content="noindex, nofollow">
```

Undangan berisi data personal dan tidak perlu diindeks search engine kecuali product requirement secara eksplisit berubah.

Jangan membuat policy SEO berbeda per-theme tanpa alasan.

---

# 28. Font

Data font:

```php
$data->dataFont?->f_title
$data->dataFont?->f_sub
$data->dataFont?->s_title
$data->dataFont?->s_sub
$data->dataFont?->titleFont
$data->dataFont?->subFont
```

Gunakan font dynamic jika theme memang mendukung custom font.

Jangan memaksa semua theme menghapus font dekoratif khas theme.

Prinsip:

- font khusus dekoratif theme boleh tetap;
- setting user yang memang dimaksudkan customizable jangan diabaikan tanpa alasan.

---

# 29. Asset Rules

Semua asset theme harus namespaced:

```text
public/tema/<theme-slug>/
```

Gunakan:

```blade
asset('tema/nama-theme/...')
```

Untuk user upload:

```blade
asset('storage/' . ltrim($path, '/'))
```

Jangan:

- memakai absolute local path;
- memakai `C:\...`;
- memakai `/home/...`;
- hardcode production domain untuk asset internal;
- mengambil image dari theme lain tanpa alasan.

Decorative asset boleh hardcoded karena bagian dari desain theme.

Data user tidak boleh hardcoded.

---

# 30. Null Safety

Theme **wajib render** pada:

1. data minimal;
2. data partial;
3. data lengkap.

Gunakan:

```php
?->
??
@isset
@if
@forelse
```

sesuai kebutuhan.

Hindari:

```php
$data->pria->image
$poto[0]
$data->acara[1]->date
$data->sound->sound
```

tanpa guard.

Lebih aman:

```php
$data->pria?->image
$data->acara?->first()?->date
$data->sound?->sound
```

Jangan memunculkan:

```text
Undefined array key
Attempt to read property ... on null
```

---

# 31. Responsive Rules

Minimal verifikasi:

- 375 px
- 390 px
- 422 px bila relevan
- 768 px
- 1024 px
- 1280 px
- 1440 px+

Untuk final acceptance theme, minimal:

```text
375 / 390 / 768 / 1024+
```

Pastikan:

- tidak ada horizontal page overflow;
- foto tidak stretch;
- fixed music button tidak menutup CTA penting;
- modal/cover bisa ditutup/dibuka;
- touch target usable;
- desktop tidak rusak karena mobile fix;
- text tidak keluar container;
- gallery tidak memaksa lebar viewport.

Jangan menggunakan global:

```css
body { overflow-x: hidden; }
```

hanya untuk menyembunyikan bug layout.

Perbaiki sumber overflow.

---

# 32. Animation Rules

Animation boleh menggunakan:

- AOS;
- CSS animation;
- IntersectionObserver;
- Swiper;
- library existing yang sudah tersedia.

Tetapi:

- jangan menghalangi interaction;
- jangan membuat content tetap hidden jika JS gagal;
- respect `prefers-reduced-motion` bila implementasinya mudah;
- jangan menambah library/dependency baru hanya untuk efek kecil;
- jangan membuat scroll listener berat untuk setiap elemen.

---

# 33. JavaScript Rules

Theme JS harus:

- namespaced secara file/folder;
- null-safe terhadap element yang tidak ada;
- tidak membuat global state yang tidak perlu;
- tidak menggandakan core music state;
- tidak bergantung pada element ID theme lain.

Gunakan:

```js
const element = document.getElementById('...');
if (element) {
    ...
}
```

Jika file JS diubah:

```bash
node --check public/tema/<theme>/js/file.js
```

untuk setiap file JS yang relevan.

---

# 34. Production Theme vs Static Demo

## Production

```text
resources/views/tema/*
```

Harus memakai dynamic data.

## Static Demo

```text
resources/views/temademo/*
```

Boleh memakai:

- nama dummy;
- image demo;
- tanggal demo;
- copy demo.

Tetapi perubahan JS shared asset harus diperiksa apakah juga dipakai oleh `temademo`.

**Jangan mengubah JS yang dipakai demo tanpa mengecek demo**, seperti kasus Flowerone `cover.js`.

Jika production dan demo memakai JS berbeda:

- dokumentasikan;
- jangan menyatukannya secara paksa.

---

# 35. Theme Feature Matrix

Untuk theme baru, audit feature berikut.

| Feature | Wedding | Birthday | Event lain |
|---|---:|---:|---:|
| Cover | Wajib | Wajib | Wajib |
| Guest name | Wajib | Wajib | Wajib |
| Main profile | Pria + Wanita | BirthdayProfile | Sesuai event type |
| Event/date/location | Wajib | Wajib | Wajib |
| Countdown | Jika desain memakai | Jika desain memakai | Jika relevan |
| Quote | Jika data ada | Optional | Optional |
| Invitation text | Wajib jika data ada | Wajib jika data ada | Wajib jika data ada |
| Gallery photo | Wajib support | Wajib support | Wajib support |
| Gallery video | Support bila dipakai | Support bila dipakai | Support bila dipakai |
| Music core | Jika theme punya music | Jika theme punya music | Jika theme punya music |
| Streaming | Jika aktif | Jika aktif | Jika aktif |
| Gift | Jika aktif | Jika aktif | Jika aktif |
| RSVP/Ucapan | Jika aktif | Jika aktif | Jika aktif |
| Love story | Jika desain memakai | Tidak dipaksakan | Tidak dipaksakan |
| Social preview | Wajib | Wajib | Wajib |
| Closing | Wajib/optional sesuai data | Wajib/optional | Wajib/optional |

---

# 36. Theme Test Contract

File utama:

```text
tests/Feature/ThemeRenderingSafetyTest.php
```

Saat menambah production theme, agent wajib menambahkan theme ke registry test yang sesuai.

## `themePaths()`

Semua production theme masuk ke:

```php
themePaths()
```

Agar otomatis ikut:

- minimal data;
- partial data;
- complete data;
- gallery regression;
- social preview regression.

## `weddingThemePaths()`

Jika event type theme = wedding:

```php
weddingThemePaths()
```

Theme wedding harus membuktikan pria + wanita keduanya render.

## `birthdayThemePaths()`

Jika birthday:

```php
birthdayThemePaths()
```

Jangan memasukkan birthday ke wedding registry.

## `musicThemePaths()`

Jika theme menggunakan core music:

```php
musicThemePaths()
```

Agar ikut test:

- sound missing;
- sound inactive;
- direct audio;
- local audio;
- YouTube;
- start 0/10/30/60;
- duplicate start prevention.

## Count-specific Test Name

Jika test/comment masih bernama seperti:

```text
all_twelve_themes
```

sementara jumlah theme sudah bertambah, update wording/count tersebut agar tidak stale.

Jangan mengubah behavior test unrelated.

---

# 37. Minimum Automated QA Theme Baru

Agent minimal menjalankan:

```bash
php artisan test tests/Feature/ThemeRenderingSafetyTest.php
git diff --check
```

Jika tersedia targeted test untuk theme:

```bash
php artisan test tests/Feature/ThemeRenderingSafetyTest.php --filter=<theme>
```

Jika JS berubah:

```bash
node --check <file-js>
```

Jika Blade/CSS theme baru punya test sendiri, jalankan juga.

---

# 38. Manual QA Theme Baru

Verifikasi production theme:

## Cover

- cover tampil;
- guest name tampil;
- tombol open bekerja;
- body bisa scroll setelah cover dibuka.

## Profile

Wedding:

- pria benar;
- wanita benar;
- image tidak tertukar.

Birthday:

- satu birthday profile;
- jangan menampilkan dua wedding profile.

## Event

- tanggal;
- jam;
- venue;
- alamat;
- maps;
- multiple acara bila tersedia.

## Gallery

Uji:

- 0 foto;
- 1 foto;
- 2 foto;
- 4+ foto.

## Music

Uji:

- start 0;
- start 30;
- start 60;
- play;
- pause;
- resume;
- inactive.

## RSVP

- feature disabled;
- public guest;
- guest code;
- submit.

## Social Preview

- view source;
- `og:title`;
- `og:description`;
- `og:image`;
- direct image URL;
- image < 500 KB.

## Viewport

- 375;
- 390;
- 768;
- 1024+.

## Console

Tidak boleh ada error JS akibat theme.

---

# 39. Hal yang Tidak Boleh Hardcoded di Production Theme

Dilarang hardcode:

- nama pengantin;
- nama birthday person;
- nama tamu;
- tanggal event;
- jam event;
- alamat;
- maps link;
- rekening;
- music URL;
- music start;
- gallery user;
- profile image user;
- cover user;
- WhatsApp thumbnail.

Boleh hardcode:

- decorative SVG;
- floral ornament;
- frame;
- background texture;
- default decorative fallback;
- label UI seperti `Gallery`, `RSVP`, `Save The Date`.

---

# 40. Jangan Mengubah Backend Hanya untuk Menyesuaikan HTML

Jika theme tidak bisa membaca data, cek:

1. variable dari controller;
2. relation existing;
3. shared partial;
4. naming field existing.

Jangan langsung:

- tambah migration;
- rename column;
- ubah model;
- ubah controller;
- tambah query.

Jika field benar-benar tidak tersedia, **STOP dan laporkan blocker**.

---

# 41. Checklist Agent Saat Menambah Theme Baru

Gunakan checklist ini sebelum menyatakan selesai.

## Struktur

- [ ] Folder Blade production dibuat.
- [ ] Asset namespaced di `public/tema/<slug>/`.
- [ ] Path production valid.
- [ ] Demo `temademo.*` valid jika dipakai.
- [ ] Event type benar.

## Dynamic Data

- [ ] Tidak ada nama user hardcoded.
- [ ] Tidak ada tanggal user hardcoded.
- [ ] Tidak ada music hardcoded.
- [ ] Tidak ada profile image user hardcoded.
- [ ] Null-safe.

## Profile

- [ ] Wedding: pria + wanita.
- [ ] Birthday: birthday profile.
- [ ] Tidak mencampur event type.

## Cover

- [ ] Cover image dynamic.
- [ ] Guest name dynamic.
- [ ] Open cover bekerja.

## Gallery

- [ ] `$poto` full loop.
- [ ] 0/1/2/4+ foto aman.
- [ ] `$video` tidak dirender sebagai image.

## Music

- [ ] Menggunakan `tema.partials.music`.
- [ ] Tidak ada legacy iframe engine.
- [ ] Tidak ada manual `?start=`.
- [ ] `musicToggle` benar jika ada tombol.
- [ ] Open cover memakai `window.musicPlayer?.play()` bila diperlukan.

## Optional Feature

- [ ] Streaming respect `isActive`.
- [ ] Gift respect `fiturKado.isActive`.
- [ ] RSVP respect `FiturUcapan`.
- [ ] Quote null-safe.
- [ ] Love story null-safe.

## Social

- [ ] Shared `components.social-preview-meta`.
- [ ] OG title/description/url/type ada.
- [ ] Tidak duplicate `og:image`.
- [ ] Social image HTTPS.
- [ ] Social image target < 500 KB.

## Responsive

- [ ] 375.
- [ ] 390.
- [ ] 768.
- [ ] 1024+.
- [ ] Tidak ada horizontal overflow.

## Test

- [ ] Tambah ke `themePaths()`.
- [ ] Tambah ke wedding/birthday registry sesuai type.
- [ ] Tambah ke `musicThemePaths()` bila menggunakan music.
- [ ] `ThemeRenderingSafetyTest` PASS.
- [ ] JS syntax PASS bila ada JS.
- [ ] `git diff --check` PASS.

---

# 42. Format Laporan Akhir Agent

Agent harus melaporkan:

```text
1. Branch
2. Nama theme
3. Event type
4. Production view path
5. Demo view path
6. File yang dibuat/diubah
7. Asset yang ditambahkan
8. Variable/data relation yang digunakan
9. Feature yang didukung
10. Social preview status
11. Music core status
12. Gallery 0/1/2/4+ status
13. Responsive 375/390/768/1024+
14. Automated test + assertions
15. node --check jika JS
16. git diff --check
17. Out-of-scope findings
18. Blocker
19. Status akhir: Selesai / Belum selesai
```

---

# 43. Template Instruksi Singkat untuk Theme Baru

Gunakan prompt berikut sebagai baseline.

```text
Ikuti seluruh aturan di AGENTS.md.
Untuk pekerjaan tema, ikuti juga seluruh aturan di THEME_RULES.md.

TASK:
Tambah production theme baru: <NAMA_THEME>

Event type:
<wedding|birthday|engagement|pengajian|event>

Referensi desain:
<REFERENSI>

Tujuan:
Implementasikan theme baru mengikuti data contract dan feature contract di THEME_RULES.md.

Scope:
- resources/views/tema/<slug>/**
- public/tema/<slug>/**
- resources/views/temademo/<slug>.blade.php jika diperlukan
- tests/Feature/ThemeRenderingSafetyTest.php

Jangan mengubah controller/model/database/shared core kecuali ditemukan blocker dan dilaporkan terlebih dahulu.

Acceptance:
- dynamic data benar;
- null-safe;
- social preview shared component;
- core music player;
- seluruh gallery dirender;
- event type profile benar;
- responsive 375/390/768/1024+;
- ThemeRenderingSafetyTest lulus;
- git diff --check bersih.

Output gunakan format laporan akhir dari THEME_RULES.md.
```

---

# 44. Source of Truth

Jika file ini berbeda dengan kode terbaru, urutan source of truth adalah:

1. `TemaController::prepareInvitationData()`
2. model relation/fillable terbaru
3. shared component/partial terbaru
4. `ThemeRenderingSafetyTest.php`
5. `THEME_RULES.md`

Setelah contract backend berubah, update file ini pada PR yang sama agar agent berikutnya tidak menggunakan aturan lama.

---

# 45. File Utama yang Harus Dikenal Agent

```text
AGENTS.md

app/Http/Controllers/TemaController.php
app/Models/Data.php
app/Models/Theme.php

resources/views/tema/partials/music.blade.php
resources/views/components/social-preview-meta.blade.php

tests/Feature/ThemeRenderingSafetyTest.php
```

Agent **tidak perlu membaca seluruh repository** untuk membuat theme baru jika contract pada file ini masih sesuai kode terbaru.

---

## Ringkasan Prinsip

```text
DATA USER      -> selalu dynamic
DECORATION     -> boleh asset theme
PROFILE        -> sesuai event type
GALLERY        -> loop seluruh $poto
VIDEO          -> gunakan $video
MUSIC          -> core partial saja
SOCIAL PREVIEW -> shared component saja
RSVP           -> endpoint existing
FEATURE FLAG   -> selalu dihormati
BLADE          -> null-safe
DATABASE       -> jangan disentuh hanya untuk theme
TEST           -> wajib masuk registry theme
RESPONSIVE     -> 375/390/768/1024+
```
