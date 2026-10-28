# Dokumentasi Integrasi Tema Pernikahan: Javanese 1 (3D Keraton & Gebyok)

## 1. Ringkasan Eksekutif

Dokumen ini mencatat integrasi dan implementasi tema pernikahan tradisional modern adat Jawa **"Javanese 1"** (3D Parallax & Gebyok Opening Gate) yang diadaptasi dari berkas referensi [`template/javanese1/javansese1.html`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/template/javanese1/javansese1.html) beserta aset modular SVG di [`template/javanese1/asset-jawa-svg/`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/template/javanese1/asset-jawa-svg/).

Integrasi diselesaikan secara mandiri mengikuti standar rekayasa perangkat lunak Laravel + Livewire + Alpine.js + TailwindCSS sesuai aturan `AGENTS.md`. Seluruh fitur 3D mutakhir (Three.js WebGL canvas, 3D Gebyok door opening cover, VanillaTilt 3D card perspective, GSAP scroll/cursor parallax) dipertahankan utuh dan dilengkapi dengan part/section pernikahan yang sebelumnya belum ada.

---

## 2. Arsitektur & Struktur Berkas

### 2.1. Berkas yang Dibuat

| Komponen | Lokasi Berkas | Keterangan |
|---|---|---|
| **Aset Gambar WebP** | [`public/tema/javanese1/assets/images/`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/public/tema/javanese1/assets/images/) | Foto pangeran, putri, pasangan hero, kisah cinta, dan lamaran berformat WebP teroptimasi |
| **Aset Vektor SVG Modular** | [`public/tema/javanese1/assets/svg/`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/public/tema/javanese1/assets/svg/) | Gunungan wayang, rumah joglo keraton, ukiran gebyok, ronce melati cempaka, motif batik kawung, daun angin Jawa |
| **Blade Demo Statis** | [`resources/views/temademo/javanese1.blade.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/resources/views/temademo/javanese1.blade.php) | Halaman preview demo statis tema (Pawiwahan Ageng 3D — Raden Aditya & Roro Kirana) |
| **Blade Dinamis Undangan** | [`resources/views/tema/javanese1.blade.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/resources/views/tema/javanese1.blade.php) | Halaman undangan dinamis produksi yang terhubung ke data Eloquent model `$data` |
| **Migrasi Registrasi Tema** | [`database/migrations/2026_10_28_060000_seed_javanese1_theme.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/database/migrations/2026_10_28_060000_seed_javanese1_theme.php) | Mendaftarkan tema ke tabel `themes` secara idempoten |
| **Automated Feature Test** | [`tests/Feature/Javanese1ThemeTest.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/tests/Feature/Javanese1ThemeTest.php) | Pengujian route demo, slug legacy, registrasi database, dynamic rendering, data minimal, dan urutan mempelai wanita pertama |

---

## 3. Fitur Desain & Estetika 3D Tradisional Jawa

Tema **Javanese 1** menggabungkan keagungan Keraton Ngayogyakarta & Surakarta dengan teknologi visual interaktif 3D:

1. **Cover Sampul 3D Gerbang Gebyok Ukir (3D Gebyok Opening Gate)**:
   - Sampul interaktif berupa dua daun pintu gebyok kayu jati dengan ukiran emas keraton.
   - Saat tombol *"Buka Gerbang Undangan"* diklik, pintu gebyok membuka secara 3D (`rotateY(-105deg)` dan `rotateY(105deg)`) dengan efek kedalaman perspektif 1400px, membuka kunci scroll layar, dan memulai instrumen gending gamelan.
2. **Three.js WebGL Particle Canvas**:
   - Efek partikel cahaya emas mistis dan serbuk temaram mengambang halus di ruang 3D kanvas tanpa membebani performa browser.
3. **Multi-layer GSAP & Mouse Cursor Parallax**:
   - Latar belakang bertingkat (Langit & siluet Gunung Merapi, Gunungan Wayang Kayon, dan Rumah Joglo) yang merespons pergerakan kursor mouse dan scroll layar.
4. **Kartu Interaktif 3D Tilt (VanillaTilt)**:
   - Kartu mempelai, acara, dan amplop merespons kemiringan pointer dengan kilauan emas (*glare*).
5. **Synthesizer Gending Jawa Pelog (Web Audio API) & MP3 Player**:
   - Synthesizer nada gamelan pelog lembut mandiri tanpa ketergantungan audio eksternal, sekaligus mendukung audio latar MP3 yang diunggah klien.
6. **Floating Studio Aset (SVG/PNG/ZIP)**:
   - Tersedia di halaman demo untuk mengekspor atau mengunduh aset-aset vektor Jawa resolusi tinggi.
7. **Interactive Lightbox Modal**:
   - Pratinjau foto galeri layar penuh dengan navigasi slide dan caption.
8. **Toast Notification Modern**:
   - Feedback halus saat menyalin nomor rekening bank atau alamat kirim kado tanpa popup alert native yang mengganggu.

---

## 4. Penambahan Part / Section yang Dilengkapi

Sesuai instruksi *"jika ada part atau section yang tidak ada bantu di tambahkan"*, tema telah dilengkapi dengan bagian esensial undangan pernikahan digital:

1. **Tata Lampah Adicara (Rundown Prosesi Adat Adicara)** (`#rundown`):
   - Timeline urutan upacara adat sakral Jawa (Pasrah Panampi, Ijab Qobul, Upacara Panggih, Pahargyan Resepsi). Pada halaman dinamis, otomatis membaca relasi `$data->rundowns`.
2. **Cariyos Katresnan (Kisah Perjalanan Cinta)** (`#cerita`):
   - Jejak perjalanan asmara kedua insan (Pertemuan Pertama, Lamaran & Silaturahmi, Menuju Janji Suci). Pada halaman dinamis, otomatis membaca relasi `$data->kisah`.
3. **Pawartos Galeri Foto & Video** (`#galeri`):
   - Grid galeri foto interaktif dengan Lightbox zoom modal, serta frame video YouTube prosesi pre-wedding jika tersedia (`$data->video`).
4. **Siaran Langsung / Virtual Wedding** (`#streaming`):
   - Kartu siaran langsung akad/resepsi via YouTube Live / Zoom / Instagram Live dengan tombol akses cepat.
5. **Kirim Kado Fisik & Amplop Digital**:
   - Tab atau kartu ganda untuk transfer bank/e-wallet dengan tombol salin otomatis nomor rekening, serta bagian alamat pengiriman kado fisik lengkap dengan tombol salin alamat.
6. **Formulir Doa Restu & RSVP**:
   - Formulir kirim doa restu yang terhubung langsung ke route `savedoa` dengan proteksi token CSRF Laravel dan daftar doa ucapan para tamu undangan.

---

## 5. Integrasi Data Eloquent & Blade Dinamis

Pada [`resources/views/tema/javanese1.blade.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/resources/views/tema/javanese1.blade.php), seluruh data dipetakan secara dinamis:

| Komponen Undangan | Relasi / Atribut Model Laravel | Fallback Aman (Null-Safe) |
|---|---|---|
| **Cover & Hero Title** | `$pria->nama_panggilan`, `$wanita->nama_panggilan`, `$data->urutan_mempelai` | Menyesuaikan urutan `wanita_pria` atau `pria_wanita` |
| **Profil Pria** | `$pria->nama_lengkap`, `$pria->deskripsi`, `$pria->instagram`, `$pria->image` | Fallback ilustrasi / gambar lokal tema |
| **Profil Wanita** | `$wanita->nama_lengkap`, `$wanita->deskripsi`, `$wanita->instagram`, `$wanita->image` | Fallback ilustrasi / gambar lokal tema |
| **Acara & Waktu** | `$acara` (koleksi model `Acara`: nama, tanggal, jam, venue, alamat, Google Maps, Google Calendar link) | Tampilan fallback format tanggal Indonesia |
| **Rundown Acara** | `$activeRundowns` (`$data->rundowns()->where('is_active', true)->orderBy('waktu_mulai')`) | Tersembunyi rapi jika kosong |
| **Kisah Cinta** | `$data->kisah` (`$data->kisah()->orderBy('id')`) | Tersembunyi rapi jika tidak diisi |
| **Galeri Foto/Video** | `$galleryPhotos` (`$data->galeri()->where('type', 'image')`), `$galleryVideos` | Lightbox zoom & modal interaktif |
| **Live Streaming** | `$data->streaming` | Tersembunyi rapi jika dinonaktifkan |
| **Amplop Digital** | `$data->kado` & `$data->fiturKado` (nomor rekening, nama bank, penerima, alamat pengiriman fisik) | Tersembunyi rapi jika `isActive == false` |
| **Doa & RSVP** | `$data->ucapan` & `$data->fiturUcapan` (form submit ke `route('savedoa')`) | Form CSRF & stream ucapan tamu |
| **Musik Latar** | `$data->sound` (`$data->sound->audio_path` atau Synthesizer Web Audio API Gending Pelog) | Default synthesizer gamelan |
| **SEO & Social Share** | `@include('components.social-preview-meta')` | Terintegrasi OpenGraph WhatsApp/Facebook/Twitter |

---

## 6. Verifikasi & Pengujian Otomatis

Pengujian automated feature test pada [`tests/Feature/Javanese1ThemeTest.php`](file:///d:/PROJECT%20WEB/Wayaenikah/undangan-digital/tests/Feature/Javanese1ThemeTest.php) dan pengujian regresi dijalankan dengan hasil seluruhnya lolos (100% passing):

```bash
php artisan test tests/Feature/Javanese1ThemeTest.php
```

Hasil eksekusi:
```text
   PASS  Tests\Feature\Javanese1ThemeTest
  ✓ demo javanese1 route renders successfully                                                                    0.31s  
  ✓ demo javanese1 legacy slug renders successfully                                                              0.08s  
  ✓ javanese1 theme is registered in database                                                                    0.09s  
  ✓ javanese1 theme renders dynamic invitation with complete wedding data                                        0.12s  
  ✓ javanese1 theme renders safely with minimal data                                                             0.09s  
  ✓ javanese1 theme respects wanita first order                                                                  0.09s  

  Tests:    6 passed (37 assertions)
  Duration: 0.92s
```

Pengujian regresi tema sebelumnya:
```bash
php artisan test tests/Feature/JavaneseCleanThemeTest.php
```

Hasil eksekusi:
```text
   PASS  Tests\Feature\JavaneseCleanThemeTest
  ✓ demo javanese clean route renders successfully                                                               0.64s  
  ✓ demo javanese clean legacy slug renders successfully                                                         0.09s  
  ✓ javanese clean theme is registered in database                                                               0.09s  
  ✓ javanese clean theme renders dynamic invitation with complete wedding data                                   0.90s  
  ✓ javanese clean theme renders safely with minimal data                                                        0.09s  
  ✓ javanese clean theme respects wanita first order                                                             0.10s  

  Tests:    6 passed (36 assertions)
  Duration: 2.05s
```

---

## 7. URL Akses & Pengujian Manual

- **Demo Tema URL**:
  - `http://127.0.0.1:8000/demo/temademo.javanese1`
  - `http://127.0.0.1:8000/demo/javanese1`
- **Contoh Undangan Tamu Personalisasi**:
  - `http://127.0.0.1:8000/demo/javanese1?to=Bapak+K.R.T.+Radjiman+Wedyodiningrat`

