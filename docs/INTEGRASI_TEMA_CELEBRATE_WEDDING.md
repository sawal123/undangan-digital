# Dokumentasi Integrasi Tema Pernikahan: Celebrate

## 1. Ringkasan Eksekutif

Dokumen ini mendokumentasikan implementasi dan integrasi tema pernikahan baru **"Celebrate"** yang diadaptasi dari berkas desain referensi [`template/celebreate.html`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/template/celebreate.html).

Integrasi ini diselesaikan secara komprehensif mengikuti standar rekayasa perangkat lunak (software engineering) yang aman, performan, responsif di seluruh breakpoint (mobile hingga desktop), serta memenuhi seluruh arsitektur data pernikahan Laravel & Livewire existing di **WayaeNikah**.

---

## 2. Arsitektur & Struktur Berkas

### 2.1. File yang Dibuat / Dimodifikasi

| Komponen | Lokasi Berkas | Keterangan |
|---|---|---|
| **Aset Gambar Teroptimasi** | [`public/tema/celebrate/assets/images/`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/public/tema/celebrate/assets/images/) | 5 aset WebP hasil ekstraksi dan deduplikasi dari base64 inline |
| **Blade Demo Statis** | [`resources/views/temademo/celebrate.blade.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/resources/views/temademo/celebrate.blade.php) | Halaman preview demo tema pernikahan (Vino & Ivelle) |
| **Blade Dinamis Undangan** | [`resources/views/tema/celebrate.blade.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/resources/views/tema/celebrate.blade.php) | Halaman undangan produksi yang terhubung ke Eloquent data user |
| **Migrasi Registrasi Tema** | [`database/migrations/2026_10_28_030000_seed_celebrate_wedding_theme.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/database/migrations/2026_10_28_030000_seed_celebrate_wedding_theme.php) | Mendaftarkan tema ke tabel `themes` secara idempoten |
| **Automated Feature Test** | [`tests/Feature/CelebrateThemeTest.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/tests/Feature/CelebrateThemeTest.php) | Pengujian route demo, migrasi DB, dan dynamic visit rendering |
| **Theme Safety Test Suite** | [`tests/Feature/ThemeRenderingSafetyTest.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/tests/Feature/ThemeRenderingSafetyTest.php) | Ditambahkan ke suite pengujian tema komprehensif |

---

## 3. Ekstraksi Aset & Optimasi Performa

Berkas mentah `template/celebreate.html` memiliki ukuran awal **~1.2 MB** yang disebabkan oleh pengulangan string base64 inline sebanyak 22 kali untuk gambar ilustrasi.

**Langkah Rekayasa Performa:**
1. Menganalisis dan mendeduplikasi gambar base64 menjadi 5 berkas WebP independen berukuran ringan (<150 KB total):
   - `couple-hero.webp` : Foto hero cover pengantin.
   - `groom.webp` : Foto portrait mempelai pria.
   - `bride.webp` : Foto portrait mempelai wanita.
   - `story.webp` : Foto ilustrasi bab kisah cinta.
   - `proposal.webp` : Foto momen tunangan / galeri.
2. Ukuran file Blade berkurang drastis dari **>1.2 MB** menjadi **~35 KB**, memangkas waktu pemrosesan render Blade dan meningkatkan First Contentful Paint (FCP) di perangkat mobile.

---

## 4. Penyesuaian Variabel Pernikahan (Wedding Domain Mapping)

Sesuai instruksi *"karena ini untuk nikah maka sesuaikan variable nya"*, template dihubungkan ke seluruh ekosistem data pernikahan WayaeNikah:

### 4.1. Pemetaan Entitas Model

| Bagian Tema | Sumber Data / Kolom | Fallback Default |
|---|---|---|
| **Cover & Hero** | `$data->coverUndangan->cover_satu`, `$data->coverUndangan->cover_dua`, `$poto[0]` | `tema/celebrate/assets/images/couple-hero.webp` |
| **Mempelai Pria & Wanita** | `$data->pria`, `$data->wanita`, urutan menghormati `$data->is_wanita_first` | `firstPerson` & `secondPerson` otomatis dinamis |
| **Nama Lengkap & Panggilan** | `$firstPerson->nama_lengkap`, `$firstPerson->nama_panggilan`, `$firstPerson->deskripsi` | Formatted title & heading |
| **Instagram Mempelai** | `$firstPerson->instagram`, `$secondPerson->instagram` | Tautan profil dengan icon |
| **Kisah Cinta (Love Story)** | `$data->kisah` (`title`, `deskripsi`, `image`) | Carousel interaktif dengan indikator titik |
| **Rangkaian Acara (Events)** | `$data->acara` (`nama_acara`, `date`, `jam_start`, `jam_end`, `zona_waktu`, `vanue`/`lokasi`, `alamat`, `maps`) | Kartu acara lengkap dengan tombol petunjuk Google Maps |
| **Rundown Acara** | `$rundowns` / `$data->rundowns->where('is_active', true)` (`waktu_mulai`, `waktu_selesai`, `nama_kegiatan`, `keterangan`, `lokasi`) | Timeline vertikal elegan dengan dot emas/sage |
| **Live Streaming** | `$data->streaming->link` | Kartu virtual attendance dengan tombol YouTube / Zoom |
| **Galeri Foto** | `$poto` / `$data->galery->pluck('poto')` | Grid 2 kolom dengan modal lightbox preview |
| **Tanda Kasih (Digital Gift)** | `$data->kado` (`giftPay->nama_pay`, `nomorPay`, `namaPay`) | Kartu rekening bank dengan tombol Salin Clipboard |
| **Kado Fisik** | `$data->fiturKado->alamat` | Alamat pengiriman dengan tombol Salin Alamat |
| **RSVP & Buku Tamu** | `route('savedoa')`, input `dataId`, `kode`, `nama`, `status`, `ucapan` | Form validasi CSRF + daftar ucapan dengan tombol Tampilkan Lebih Banyak |
| **Musik Latar Belakang** | `$data->sound->audio` | Tag `<audio>` + Synth Web Audio API romantis otomatis jika file belum ada |
| **Kalender Acara** | Google Calendar URL yang digenerate dinamis dari tanggal acara | Link "Simpan ke Kalender" |
| **SEO & Social Share** | `@include('components.social-preview-meta')` | OpenGraph tags & meta title/description |

---

## 5. Fitur Interaktif UI/UX & Desain

Tema **Celebrate** menerapkan palet warna botanical kontemporer yang elegan:
- **Ivory (`#FDFBF7`)** & **Cream (`#F5EFE6`)**: Warna dasar kertas bertekstur lembut (*paper texture*).
- **Sage (`#5F7E5F`)**: Aksen dedaunan alami untuk tombol utama dan status kehadiran.
- **Muted Gold (`#B59B6D`)**: Garis batas ornamentasi, monogram cinta, dan tombol interaksi.
- **Dusty Rose (`#C8A29C`)**: Aksen romantis dan kelopak bunga melayang (*floating petals*).
- **Espresso (`#3A322C`)**: Kontras tipografi Cormorant Garamond & Plus Jakarta Sans yang ramah dibaca.

### Fitur Interaktif Unggulan:
1. **Cover Layar Penuh dengan Animasi Transisi Halus**:
   - Menghalangi interaksi halaman sebelum tamu menekan tombol *"Buka Undangan"*.
   - Saat ditekan, cover bergeser ke atas secara mulus (`transform: translateY(-100%)`), mengaktifkan scroll body, dan otomatis memulai musik pernikahan.
2. **Kelopak Bunga Melayang (Botanical Petals Generator)**:
   - Partikel kelopak SVG ringan yang jatuh perlahan di latar belakang dengan durasi dan penundaan dinamis.
3. **Hitung Mundur Waktu Nyata (Real-time Countdown Timer)**:
   - Menghitung hari, jam, menit, dan detik menuju waktu acara akad nikah pertama.
4. **Interactive Lightbox Modal**:
   - Klik pada foto galeri akan membuka modal pratinjau resolusi tinggi dengan navigasi Sebelumnya/Selanjutnya (*keyboard & touch friendly*).
5. **Toast Notification Feedback**:
   - Umpan balik visual instan saat tamu menyalin nomor rekening bank atau alamat kirim kado.
6. **Floating Music Controller & Bottom Navigation Dock**:
   - Piringan pemutar musik yang dapat dijeda/dimainkan kapan saja.
   - Quick navigation dock di bagian bawah untuk melompat langsung ke seksi Home, Mempelai, Kisah, Acara, Hadiah, atau Doa.

---

## 6. Verifikasi & Pengujian

### 6.1. Unit & Feature Testing
Pengujian otomatis dilakukan melalui PHPUnit/Laravel Test Suite:

```bash
php artisan test tests/Feature/CelebrateThemeTest.php
```

**Hasil Pengujian:**
- `✓ demo celebrate route renders successfully` (200 OK)
- `✓ demo celebrate legacy slug renders successfully` (200 OK)
- `✓ celebrate theme is registered in database` (Tervalidasi di DB)
- `✓ celebrate theme renders dynamic invitation with complete wedding data` (Data binding terverifikasi)

### 6.2. Theme Safety Integration
Tema `tema.celebrate` telah dimasukkan ke dalam `tests/Feature/ThemeRenderingSafetyTest.php` untuk memastikan ketahanan render terhadap data kosong (*empty relation fallback*), urutan wanita pertama (*is_wanita_first*), dan kelengkapan rundown.

---

## 7. URL Akses & Demo

- **Demo Preview**: `http://localhost:8000/demo/celebrate` atau `http://localhost:8000/demo/temademo.celebrate`
- **Undangan Tamu**: `http://localhost:8000/u/{slug}/{kode_tamu?}`
