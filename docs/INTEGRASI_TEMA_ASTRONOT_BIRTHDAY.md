# Dokumentasi Integrasi Tema Ulang Tahun: Astronot

## 1. Ringkasan Eksekutif

Dokumen ini menjelaskan implementasi dan integrasi tema ulang tahun anak baru **"Astronot"** (Misi Ulang Tahun Antariksa) yang diadaptasi dari berkas referensi [`template/astronot.html`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/template/astronot.html).

Integrasi ini diselesaikan mengikuti instruksi *"karena ini untuk ulang tahun maka sesuaikan variable nya"* serta mematuhi kaidah rekayasa perangkat lunak (software engineering) yang aman, performan, responsif di seluruh ukuran layar (mobile hingga desktop), dan terikat secara menyeluruh dengan arsitektur data kategori **Ulang Tahun** di **WayaeNikah**.

---

## 2. Arsitektur & Berkas yang Dibuat

| Komponen | Lokasi Berkas | Keterangan |
|---|---|---|
| **Aset Gambar Teroptimasi** | [`public/tema/astronot/assets/images/`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/public/tema/astronot/assets/images/) | 3 berkas WebP hasil ekstraksi dan deduplikasi dari base64 inline |
| **Blade Demo Statis** | [`resources/views/temademo/astronot.blade.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/resources/views/temademo/astronot.blade.php) | Halaman preview demo tema ulang tahun (Kapten Leo Pratama) |
| **Blade Dinamis Undangan** | [`resources/views/tema/astronot.blade.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/resources/views/tema/astronot.blade.php) | Halaman undangan produksi yang terikat pada model Laravel data user |
| **Migrasi Registrasi Tema** | [`database/migrations/2026_10_28_040000_seed_astronot_birthday_theme.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/database/migrations/2026_10_28_040000_seed_astronot_birthday_theme.php) | Mendaftarkan tema ke tabel `themes` dengan `event_type_id: 2` & `category_id: 2` |
| **Automated Feature Test** | [`tests/Feature/AstronotThemeTest.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/tests/Feature/AstronotThemeTest.php) | Pengujian rute demo, migrasi database, data lengkap ultah, dan fallback data minimal |

---

## 3. Ekstraksi Aset & Optimasi Performa

Berkas mentah `template/astronot.html` memiliki ukuran awal **~760 KB** karena memuat gambar base64 inline yang sangat panjang (mencapai lebih dari 120.000 karakter per tag).

**Optimasi Rekayasa Performa:**
1. Menganalisis dan mengekstraksi 3 gambar unik ke format WebP berkualitas tinggi:
   - `captain-avatar.webp` (~77 KB): Foto ilustrasi kapten astronot cilik.
   - `moon-cake.webp` (~70 KB): Foto kue ulang tahun di kawah bulan.
   - `rocket-launch.webp` (~66 KB): Foto peluncuran roket luar angkasa.
2. Ukuran file Blade terpangkas drastis dari **~760 KB** menjadi **~37 KB**, mencegah deteksi binary oleh git/ripgrep dan melipatgandakan kecepatan *First Contentful Paint* (FCP) di koneksi mobile.

---

## 4. Pemetaan Variabel Kategori Ulang Tahun (Birthday Domain Mapping)

Seluruh komponen tema dihubungkan dengan model data kategori **Ulang Tahun (`key: birthday`)**:

| Bagian Tema | Sumber Data / Kolom Model | Nilai Fallback Default |
|---|---|---|
| **Profil Anak / Kapten** | `$data->birthdayProfile?->name`, `$data->birthdayProfile?->nickname` | `$data->title` / `Kapten Leo Pratama` |
| **Usia Ulang Tahun** | `$data->birthdayProfile?->age` | `5` |
| **Nama Orang Tua** | `$data->birthdayProfile?->parent_name` | `$data->setting?->orang_tua` |
| **Kata Sambutan / Deskripsi** | `$data->birthdayProfile?->description` | `$data->teksUndangan?->teks` |
| **Foto Utama & Hero** | `$data->birthdayProfile?->photo`, `$data->coverUndangan?->cover_satu`, `$poto[0]` | `tema/astronot/assets/images/captain-avatar.webp` |
| **Headline Acara** | `$data->eventDetail?->headline` | `Misi Ulang Tahun Antariksa` |
| **Kode Seragam (Dresscode)** | `$data->eventDetail?->dress_code` | `Biru / Putih / Kosmik` |
| **Waktu & Tanggal Acara** | `$firstEvent->date`, `$firstEvent->jam_start`, `$firstEvent->jam_end`, `$firstEvent->zona_waktu` | Tanggal dan jam terformat Carbon Indonesia |
| **Stasiun Pesta / Lokasi** | `$firstEvent->vanue`, `$firstEvent->lokasi`, `$firstEvent->alamat` | `Starlight Kids Cafe & Hall` |
| **Peta Lokasi** | `$firstEvent->maps`, `$firstEvent->link_map` | Link pencarian Google Maps |
| **Tahapan Misi (Rundown)** | `$rundowns` / `$data->rundowns->where('is_active', true)` (`waktu_mulai`, `waktu_selesai`, `nama_kegiatan`, `keterangan`, `lokasi`) | Timeline 4 kartu misi kosmik terstruktur |
| **Galeri Momen Ceria** | `$poto` / `$data->galery->pluck('poto')` | Grid 3 kolom dengan modal lightbox |
| **Tanda Kasih (Kado Digital)** | `$data->kado` (`giftPay->nama_pay`, `nomorPay`, `namaPay`) | Kartu rekening bank dengan tombol Salin No. Rek |
| **Kado Fisik** | `$data->fiturKado->alamat` | Alamat pengiriman paket dengan tombol Salin Alamat |
| **RSVP Kehadiran Kru** | Form submit ke `route('savedoa')` (`dataId`, `kode`, `nama`, `status`, `ucapan`) | Validasi CSRF + daftar ucapan dengan tombol Tampilkan Semua |
| **Musik Latar Belakang** | `$data->sound?->audio` | Tag `<audio>` + Web Audio API synthesizer space arpeggio otomatis jika belum upload audio |
| **Kalender Otomatis** | URL Google Calendar yang digenerate otomatis | Tautan "Simpan ke Kalender" |
| **SEO & OpenGraph** | `@include('components.social-preview-meta')` | Meta title & description adaptif |

---

## 5. Fitur Interaktif UI/UX & Desain

Tema **Astronot** mengusung gaya visual *deep space futuristic & playful kids cosmic*:
- **Latar Belakang Kosmik**: Perpaduan gelap `#060818` & `#0B102B` dengan aksen nebula cyan (`#38BDF8`), amber (`#FBBF24`), purple (`#A855F7`), dan pink (`#F472B6`).
- **Starfield Canvas Particle**: Canvas HTML5 interaktif yang merender partikel bintang bergerak secara halus dengan opacity dan kecepatan acak.
- **Cover Gate Layar Penuh**:
  - Tamu disambut dengan kartu pintu masuk bertuliskan "Panggilan Misi Antariksa", foto kapten, dan nama tamu.
  - Tombol *"Buka Akses Kontrol"* membuka halaman secara mulus dan otomatis mengaktifkan musik latar.
- **Web Audio API Space Synth**:
  - Jika pengguna belum mengunggah file musik, sistem memutar synthesizer arpeggio nada kosmik ceria (C5, E5, G5, C6) secara looping tanpa memerlukan dependensi file eksternal.
  - Tombol toggle audio di header memungkinkan pengunjung menjeda atau memutar ulang kapan saja.
- **Countdown Peluncuran Roket (T-Minus)**:
  - Hitung mundur waktu nyata (hari, jam, menit, detik) menuju jam pelaksanaan pesta.
- **Lightbox Preview**:
  - Modal pratinjau foto resolusi penuh saat tamu menekan foto di seksi galeri.
- **Salin Clipboard dengan Toast Feedback**:
  - Salin instan nomor rekening bank dan alamat kirim kado dengan notifikasi visual melayang.
- **Mobile Bottom Quick Navigation**:
  - Menu melayang di bagian bawah layar ponsel untuk memudahkan navigasi instan antar seksi.

---

## 6. Verifikasi & Pengujian

### 6.1. Pengujian Otomatis
Pengujian automated dilakukan melalui PHPUnit/Laravel Feature Test:

```bash
php artisan test tests/Feature/AstronotThemeTest.php
```

**Hasil Pengujian:**
- `✓ demo astronot route renders successfully` (200 OK)
- `✓ demo astronot legacy slug renders successfully` (200 OK)
- `✓ astronot theme is registered in database` (Tervalidasi di DB: category_id 2, event_type_id 2)
- `✓ astronot theme renders dynamic invitation with complete birthday data` (Data binding lengkap terverifikasi)
- `✓ astronot theme renders safely with minimal data` (Render aman saat data opsional kosong)

Semua 5 pengujian (29 assertions) lulus dengan status **PASS**.

### 6.2. Uji Regresi Keseluruhan
Menjalankan pengujian fitur tema dan alur kelola yang ada:

```bash
php artisan test tests/Feature/AstronotThemeTest.php tests/Feature/CelebrateThemeTest.php tests/Feature/BirthdayCategoryFlowTest.php tests/Feature/KelolaEnhancementsTest.php
```
**Hasil:** 27 passed (111 assertions), **0 failure**.

---

## 7. URL Akses & Pratinjau

- **Demo Tema**: `http://localhost:8000/demo/astronot` atau `http://localhost:8000/demo/temademo.astronot`
- **Undangan Tamu**: `http://localhost:8000/u/{slug}/{kode_tamu?}` (saat pengguna memilih tema Astronot pada undangan kategori Ulang Tahun)
