# Dokumentasi Integrasi Tema Pernikahan: Javanese Clean

## 1. Ringkasan Eksekutif

Dokumen ini mencatat integrasi dan implementasi tema pernikahan tradisional modern adat Jawa **"Javanese Clean"** yang diadaptasi dari berkas referensi [`template/javanese-clean.html`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/template/javanese-clean.html).

Integrasi diselesaikan secara komprehensif mengikuti standar rekayasa perangkat lunak (software engineering) yang aman, performan, responsif di seluruh breakpoint (mobile hingga desktop), serta memenuhi seluruh arsitektur data pernikahan Laravel & Livewire existing di **WayaeNikah** tanpa merusak file lain.

---

## 2. Arsitektur & Struktur Berkas

### 2.1. Berkas yang Dibuat

| Komponen | Lokasi Berkas | Keterangan |
|---|---|---|
| **Aset WebP Teroptimasi** | [`public/tema/javanese-clean/assets/images/`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/public/tema/javanese-clean/assets/images/) | Aset WebP untuk thumbnail, fallback hero, mempelai, kisah cinta, dan galeri |
| **Blade Demo Statis** | [`resources/views/temademo/javanese-clean.blade.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/resources/views/temademo/javanese-clean.blade.php) | Halaman preview demo tema (Pawiwahan Ageng — Raden Aditya & Roro Kirana) |
| **Blade Dinamis Undangan** | [`resources/views/tema/javanese-clean.blade.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/resources/views/tema/javanese-clean.blade.php) | Halaman undangan produksi yang terhubung ke data Eloquent model `$data` |
| **Migrasi Registrasi Tema** | [`database/migrations/2026_10_28_050000_seed_javanese_clean_theme.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/database/migrations/2026_10_28_050000_seed_javanese_clean_theme.php) | Mendaftarkan tema ke tabel `themes` secara idempoten |
| **Automated Feature Test** | [`tests/Feature/JavaneseCleanThemeTest.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/tests/Feature/JavaneseCleanThemeTest.php) | Pengujian route demo, slug legacy, registrasi database, dynamic rendering, data minimal, dan urutan mempelai wanita pertama |

---

## 3. Fitur Desain & Estetika Tradisional Jawa

Tema **Javanese Clean** mengusung filosofi *Memayu Hayuning Bawana* dengan palet warna dan ornamen khas Keraton Jawa:
- **Sogan Gelap (`#160B06` - `#24130B`)**: Warna dasar kayu jati dan batik klasik sogan yang sakral nan megah.
- **Emas Keraton (`#D4AF37` - `#F3E09B`)**: Aksen gradasi emas metalik untuk ornamen ukiran sudut, kemuncak joglo, dan tipografi.
- **Krem / Gading (`#FDFBF7` - `#F7F1E3`)**: Kontras lembut bertekstur kertas kuno (*parchment*) dengan motif Batik Kawung halus.
- **Hijau Daun Beringin (`#2D4A3E` - `#1E352B`)**: Dedaunan alami dan untaian Ronce Melati gantung yang bergoyang pelan tertiup angin.
- **Tipografi Harmonis**:
  - `Great Vibes`: Huruf aksen kaligrafi romantis untuk nama pengantin.
  - `Cormorant Garamond`: Font serif elegan untuk tata bahasa dan nuansa klasik.
  - `Plus Jakarta Sans`: Sans-serif modern dan nyaman dibaca untuk detail acara dan formulir.

### Fitur Interaktif Unggulan:
1. **Cover Sampul Undangan Layar Penuh (Joglo Vector & Glowing Lantern)**:
   - Sampul interaktif dengan ilustrasi Rumah Joglo Jawa, siluet pengantin di gebyok berhias cahaya lentera hangat, dan ronce melati.
   - Tombol *"Buka Undangan"* membuka kunci scroll dan memulai gending gamelan / musik latar belakang.
2. **Animasi Canvas Partikel Melati & Kunang-kunang Emas**:
   - Efek kelopak melati putih gading, helai daun, dan serbuk emas melayang secara halus di latar belakang.
3. **Synthesizer Gending Jawa Pelog (Web Audio API)**:
   - Menghasilkan nada metalofon gamelan pelog lembut secara mandiri tanpa memerlukan file audio eksternal, dengan fallback tag `<audio>` untuk lagu MP3 yang diunggah pengguna.
4. **Hitung Mundur Waktu Nyata (Live Countdown)**:
   - Penghitung hari, jam, menit, dan detik menuju waktu acara akad nikah.
5. **Interactive Lightbox Modal**:
   - Zoom pratinjau foto galeri layar penuh dengan navigasi sebelumnya/selanjutnya.
6. **Toast Notification Tanpa Alert**:
   - Notifikasi mengambang saat menyalin nomor rekening bank atau alamat kirim kado.

---

## 4. Penambahan Part / Section yang Dilengkapi

Sesuai instruksi *"jika ada part atau section yang tidak ada bantu di tambahkan"*, tema ini telah dilengkapi dengan bagian-bagian penting pernikahan:

1. **Tata Lampah Adicara (Rundown Acara Jawa)**:
   - Timeline vertikal elegan untuk susunan prosesi adat (Pasrah Panampi, Ijab Qobul, Panggih, Balangan Gantal, Kacar Kucur, Sungkeman, Pahargyan Resepsi).
2. **Cariyos Katresnan (Kisah Cinta / Love Story)**:
   - Rangkaian bab perjalanan cinta pengantin dengan kartu foto berornamen emas (Tepang Kapisan, Nglajengaken Prasetya, Menuju Pelaminan).
3. **Pawartos Foto & Galeri Momen**:
   - Grid galeri foto responsif dengan efek hover pembesar dan modal lightbox pratinjau resolusi tinggi, serta pemutar video prewedding.
4. **Siaran Langsung (Virtual Attendance)**:
   - Bagian siaran daring YouTube / Zoom bagi tamu yang berhalangan hadir secara langsung.
5. **Kirim Kado Fisik & QRIS**:
   - Kartu alamat pengiriman hadiah fisik lengkap dengan tombol salin alamat, serta dukungan penampil kode QRIS pembayaran.
6. **Navigasi Bawah Lengkap (7 Menu Shortcut)**:
   - Dock navigasi bawah mencakup Beranda, Mempelai, Acara, Kisah, Galeri, Hadiah, dan Ucapan.

---

## 5. Pemetaan Domain Data Undangan (Dynamic Data Binding)

| Bagian Tema | Sumber Data Model Laravel | Fallback / Default |
|---|---|---|
| **Cover & Hero** | `$data->coverUndangan->cover_satu`, `$poto[0]` | `tema/javanese-clean/assets/images/couple-hero.webp` |
| **Mempelai Pria & Wanita** | `$data->pria`, `$data->wanita`, urutan menghormati `$data->is_wanita_first` | First & Second Person otomatis dinamis |
| **Foto Profil Mempelai** | `$firstPerson->image`, `$secondPerson->image` | Vektor SVG autentik Blangkon Jawa & Paes Ageng |
| **Nama & Deskripsi Ortu** | `$firstPerson->nama_lengkap`, `$firstPerson->deskripsi` | Nama panggilan & gelar |
| **Instagram Mempelai** | `$firstPerson->instagram`, `$secondPerson->instagram` | Tautan profil sosial media |
| **Ayat Suci & Quote** | `$data->qoute->qoute`, `$data->teksUndangan->teks_satu` | QS. Ar-Rum: 21 & Falsafah Jawa Witing Tresna |
| **Rangkaian Acara** | `$data->acara` (`nama_acara`, `date`, `jam_start`, `jam_end`, `zona_waktu`, `vanue`/`lokasi`, `alamat`, `maps`) | Kartu acara dinamis + Google Maps & Calendar button |
| **Tata Lampah Adicara** | `$activeRundowns` (`waktu_mulai`, `waktu_selesai`, `nama_kegiatan`, `keterangan`, `lokasi`) | Timeline vertikal bila ada data aktif |
| **Cariyos Katresnan** | `$data->kisah` (`title`, `deskripsi`, `image`) | Grid kisah cinta bila ada data aktif |
| **Galeri Foto & Video** | `$galleryPhotos`, `$galleryVideos` | Grid galeri responsif + lightbox zoom |
| **Live Streaming** | `$data->streaming->link` | Kartu virtual attendance bila link streaming aktif |
| **Amplop Digital** | `$data->kado` (`giftPay->nama_pay`, `nomorPay`, `namaPay`, `qris`) | Kartu rekening bank dengan tombol salin clipboard |
| **Kado Fisik** | `$data->fiturKado->alamat` | Alamat pengiriman dengan tombol salin alamat |
| **Konfirmasi RSVP** | `route('savedoa')`, input `dataId`, `kode`, `nama`, `status`, `ucapan` | Form CSRF + feed komentar tamu diffForHumans |
| **Musik Latar Belakang** | `$data->sound->audio` | Tag audio MP3 + fallback synthesizer Gamelan Pelog |
| **SEO & Social Share** | `@include('components.social-preview-meta')` | OpenGraph tags & meta title/description |

---

## 6. Verifikasi & Pengujian Otomatis

Suite pengujian komprehensif dijalankan menggunakan PHPUnit:

```bash
php artisan test tests/Feature/JavaneseCleanThemeTest.php
```

**Hasil Pengujian:**
- `✓ demo javanese clean route renders successfully` (200 OK)
- `✓ demo javanese clean legacy slug renders successfully` (200 OK)
- `✓ javanese clean theme is registered in database` (Tervalidasi di tabel themes)
- `✓ javanese clean theme renders dynamic invitation with complete wedding data` (Data binding lengkap)
- `✓ javanese clean theme renders safely with minimal data` (Null-safe fallback)
- `✓ javanese clean theme respects wanita first order` (Pengaturan urutan wanita pertama terverifikasi)

Semua pengujian berjalan 100% lulus tanpa kegagalan (6 passed, 36 assertions).

---

## 7. URL Akses & Demo

- **Demo Preview (Namespace)**: `http://localhost:8000/demo/temademo.javanese-clean`
- **Demo Preview (Slug)**: `http://localhost:8000/demo/javanese-clean`
- **Undangan Tamu**: `http://localhost:8000/u/{slug}/{kode_tamu?}`

