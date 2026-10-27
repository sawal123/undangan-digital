# Plan & Dokumentasi: Enhancement Modul Kelola & Fitur Baru Rundown Acara

**Branch Rencana:** `feature/kelola-enhancement-and-rundown`  
**Tanggal:** 27 Oktober 2026  
**Status:** Menunggu Konfirmasi User Sebelum Eksekusi  

---

## 1. Ringkasan Eksekutif & Sasaran

Berdasarkan hasil scanning menyeluruh dan arahan prioritas pengguna, rencana ini merangkum perbaikan konsistensi UI/UX, penguatan fungsionalitas modul kelola undangan eksisting, serta pembuatan fitur baru **Rundown Acara (Susunan Acara)** lengkap dengan switch kontrol `is_active`.

Pekerjaan difokuskan pada 8 poin utama yang telah disetujui:
1. **Preview Image:** Penyempurnaan UX preview foto (tombol batal/reset file baru, badge status foto baru vs eksisting, visual placeholder yang konsisten).
2. **Modul Acara:** Pembersih otomatis link Google Maps (ekstraksi URL dari kode embed `<iframe>` jika user menempelkan kode iframe) + tombol helper generator pencarian lokasi.
3. **Tamu & RSVP:** Penambahan fitur **Export CSV** (rekap tamu & RSVP) dan **Import CSV** (unggah daftar tamu massal dengan template standar).
4. **Galeri:** Peningkatan kejelasan visual tombol reordering yang sudah ada dengan penambahan nomor urut/posisi (`#1`, `#2`, dst.) dan tooltip arah.
5. **Tema per Kategori:** Filter interaktif tab/kategori tema agar user dapat memfilter tema berdasarkan kategori (Semua, Wedding, Floral, Modern, dll.).
6. **Auto-Generate Slug:** Tombol pembuat slug otomatis di Pengaturan berbasis nama mempelai/judul dengan penanganan duplikasi slug otomatis.
7. **Perbaikan Celah Overview Hub:** Menghilangkan `alert()` browser saat salin link, menggantinya dengan toast/feedback visual modern, serta melengkapi status kesiapan undangan.
8. **Fitur Baru Rundown Acara:** Pembuatan modul susunan acara lengkap (tabel database, migrasi aman, model, Livewire component, UI timeline responsif, reordering, dan toggle aktif/nonaktif `is_active`).

---

## 2. Rincian Teknis & Arsitektur Implementasi

### A. Preview Image (Pria, Wanita, Setting, Kisah)
* **Kondisi Eksisting:** Preview image sudah tersedia menggunakan `$image->temporaryUrl()`, namun ketika user memilih file baru yang salah, tidak ada tombol "Batal Ganti" sebelum form disimpan, dan belum ada indikator yang membedakan foto lama vs foto baru yang belum tersimpan.
* **Solusi & Perbaikan:**
  - Tambahkan tombol `Batal Ganti` (`wire:click="$set('newImage', null)"`) saat ada foto baru yang dipilih.
  - Tampilkan badge kecil yang informatif: `Foto Saat Ini` (jika memakai foto lama) atau `Foto Baru (Belum Disimpan)` (jika baru diunggah).
  - Berikan transisi visual dan aspect-ratio yang rapi dengan bingkai rounded-2xl dan state hover.

### B. Modul Acara (Google Maps Embed Sanitizer & Helper)
* **Kondisi Eksisting:** Input peta menerima URL, namun banyak user awam yang menyalin seluruh kode embed iframe dari Google Maps (`<iframe src="https://www.google.com/maps/embed?..." ...></iframe>`), yang menyebabkan link rusak di tema undangan.
* **Solusi & Perbaikan:**
  - Di `app/Livewire/DashboardDemo/Kelola/Acara.php`, pada method `save()`, tambahkan sanitizer:
    ```php
    if (preg_match('/src="([^"]+)"/', $this->maps, $matches)) {
        $this->maps = $matches[1];
    }
    $this->maps = trim(strip_tags($this->maps));
    ```
  - Tambahkan tombol helper cerdas di form: *"Buat Link Maps Otomatis dari Alamat & Venue"* yang mengisi URL pencarian Google Maps (`https://www.google.com/maps/search/?api=1&query=...`) jika user belum memiliki URL maps spesifik.
  - Perjelas UI waktu: saat opsi *"Sampai Selesai"* dicentang, input jam selesai dinonaktifkan dengan label visual yang tegas.

### C. Fitur Import & Export Tamu & RSVP
* **Kebutuhan:** Memudahkan mempelai mengelola ratusan tamu tanpa perlu input manual satu per satu, dan merekap data kehadiran untuk katering/panitia.
* **Solusi & Perbaikan di `Tamu.php`:**
  1. **Export CSV (RSVP & Tamu):**
     - Livewire action: `exportCsv()`
     - Format: `Nama Tamu, WhatsApp, Status Kehadiran, Jumlah Orang, Link Undangan`
     - Menggunakan `response()->streamDownload()` bawaan Laravel (ringan, cepat, aman untuk memory, kompatibel penuh dengan Microsoft Excel dan Google Sheets).
  2. **Import CSV Tamu:**
     - Modal: `import-tamu-modal`
     - Input file upload CSV/TXT (`$csvFile`).
     - Tombol *"Unduh Contoh Template CSV"* (`Nama,WhatsApp`).
     - Parser CSV aman dengan validasi baris, penomoran WhatsApp otomatis (`normalizeWhatsAppNumber`), pembuatan kode tamu unik (`generateGuestCode()`), dan slug.
     - Laporan umpan balik ringkas (contoh: *"Berhasil mengimpor 35 tamu baru"*).

### D. Galeri (Penyempurnaan Indikator Geser Posisi)
* **Kondisi Eksisting:** Di `Galery.php` dan `galery.blade.php`, tombol `previous($sort)` dan `next($sort)` sudah ada dan berfungsi.
* **Solusi & Perbaikan:**
  - Tambahkan badge nomor urut dinamis di pojok kartu foto/video (misal: `#1`, `#2`, `#3`) agar user dapat melihat langsung urutan foto saat ini di tema.
  - Perbaiki tata letak dan affordance tombol panah kiri/kanan dengan tooltip yang jelas (`Pindahkan ke kiri/sebelumnya` & `Pindahkan ke kanan/berikutnya`).
  - Berikan visual feedback loading spinner saat tombol ditekan agar user tahu posisi sedang diproses.

### E. Filter Tema per Kategori
* **Kondisi Eksisting:** Seluruh tema dimuat dalam satu grid panjang tanpa pemisahan kategori.
* **Solusi & Perbaikan di `Tema.php` & `tema.blade.php`:**
  - Tambahkan properti `public string $selectedCategory = 'all';`
  - Ambil daftar kategori aktif via `Category::has('themes')->get()` atau `Category::all()`.
  - Tambahkan komponen tabs/pills horizontal responsif di bagian atas galeri tema:
    - `[Semua (X)]`, `[Wedding (Y)]`, `[Birthday (Z)]`, dst.
  - Query tema otomatis memfilter berdasarkan kategori terpilih secara reaktif.

### F. Auto-Generate Slug di Pengaturan
* **Kondisi Eksisting:** User harus mengetik slug secara manual dan memeriksa ketersediaannya.
* **Solusi & Perbaikan di `Setting.php` & `setting.blade.php`:**
  - Tambahkan tombol di samping input slug: *"Generate dari Nama"*.
  - Logika pembuat slug:
    1. Jika data pengantin terisi, gunakan format nama pasangan (memperhitungkan `urutan_mempelai` jika wanita di depan).
    2. Jika data pengantin belum ada, gunakan `title` undangan.
    3. Jika slug hasil generate sudah dipakai oleh undangan lain di database, otomatis tambahkan suffix angka unik (misal: `putri-dan-jimmi-2`).
  - Otomatis trigger pengecekan slug availability sehingga tombol simpan langsung aktif.

### G. Perbaikan Celah Overview Hub
* **Kondisi Eksisting:** Pada `resources/views/livewire/dashboard/kelola/index.blade.php`, fungsi salin link masih menggunakan browser native `alert('Link berhasil disalin!')`.
* **Solusi & Perbaikan:**
  - Ganti dengan mekanisme Alpine.js clipboard feedback: saat tombol ditekan, tombol berganti ikon checkmark hijau dan label teks *"Tersalin!"* selama 2 detik.
  - Perjelas kartu status: tampilkan badge status kelengkapan dan tombol bagikan/review.
  - Daftarkan modul baru **Rundown Acara** ke dalam grid modul dashboard.

### H. Fitur Baru: Rundown Acara (Susunan Acara)
* **Kebutuhan:** Mempelai membutuhkan jadwal susunan acara (timeline) pada hari pernikahan/event (misal: Akad Nikah, Temu Manten, Foto Bersama, Ramah Tamah, Hiburan), serta kontrol `is_active` untuk menampilkan/menyembunyikan jadwal tertentu.
* **Komponen & Arsitektur:**
  1. **Migrasi Database (`database/migrations/2026_10_27_140000_create_rundowns_table.php`):**
     - `id` (bigIncrements)
     - `data_id` (foreignId ke tabel `data`, cascade delete)
     - `acara_id` (foreignId ke tabel `acaras`, nullable, set null on delete) -> agar rundown bisa dikaitkan ke acara tertentu (Akad/Resepsi) atau umum.
     - `waktu_mulai` (string, misal: "08:00")
     - `waktu_selesai` (string nullable, misal: "09:30" atau "Selesai")
     - `nama_kegiatan` (string, max 255)
     - `keterangan` (text nullable, misal catatan PIC/pengisi acara)
     - `lokasi` (string nullable, misal: "Masjid / Ruang Utama")
     - `is_active` (boolean, default true) -> *Sesuai permintaan khusus user*
     - `sort` (integer, default 1)
     - `timestamps`
  2. **Model (`app/Models/KelolaUndangan/Rundown.php`):**
     - Fillable: `data_id`, `acara_id`, `waktu_mulai`, `waktu_selesai`, `nama_kegiatan`, `keterangan`, `lokasi`, `is_active`, `sort`.
     - Relasi: `belongsTo(Data::class)`, `belongsTo(Acara::class)`.
  3. **Livewire Component (`app/Livewire/DashboardDemo/Kelola/Rundown.php`):**
     - Menggunakan trait `LoadsOwnedInvitation` (konsisten dengan standar keamanan multi-tenant project).
     - Fitur:
       - Tambah & Edit Rundown melalui modal.
       - Hapus Rundown.
       - Quick Toggle `toggleActive($id)` untuk mengaktifkan/menonaktifkan item tanpa reload.
       - Reordering item: `moveUp($sort)` & `moveDown($sort)`.
       - Filter berdasarkan Acara (Semua Acara / Akad / Resepsi).
  4. **Blade View (`resources/views/livewire/dashboard/kelola/rundown.blade.php`):**
     - Tampilan Timeline Cards modern dan elegan (dukungan Dark Mode & Light Mode).
     - Tombol aksi: Edit, Hapus, Toggle Switch Aktif/Nonaktif, Geser Atas/Bawah.
  5. **Routing & Menu:**
     - Route: `Route::get('/kelola/{id}/rundown', \App\Livewire\DashboardDemo\Kelola\Rundown::class)->name('undangan.rundown');`
     - Ditambahkan ke daftar modul di `Index.php` dan tautan cepat dari halaman `Acara`.

---

## 3. Rencana Pengujian (Test Suite)

Untuk menjamin tidak ada regresi dan semua fitur berjalan stabil:
1. **Unit & Feature Test:**
   - `AcaraMapsSanitizerTest.php`: Memastikan URL iframe maps otomatis terurai menjadi link bersih.
   - `TamuImportExportTest.php`: Memastikan export CSV menghasilkan header dan baris valid, dan import CSV berhasil menyimpan tamu baru dengan kode unik.
   - `SettingAutoSlugTest.php`: Memastikan auto-generate slug menghasilkan format yang rapi dan menangani slug kembar dengan benar.
   - `RundownAcaraTest.php`: Memastikan CRUD rundown, reordering, dan toggle `is_active` berjalan sesuai hak kepemilikan user.
2. **Regression Testing:**
   - Menjalankan kembali test sebelumnya: `UrutanMempelaiTest`, `TamuRsvpUnifiedTest`, `ThemeRenderingSafetyTest`.
3. **Build & Assets Validation:**
   - Menjalankan `npm run build` untuk memastikan tidak ada kesalahan kompilasi frontend Tailwind/Vite.

---

## 4. Hasil Eksekusi & Status Verifikasi

1. [x] Buat branch baru: `feature/kelola-enhancement-and-rundown`.
2. [x] Buat migrasi tabel `rundowns` (`2026_10_27_141000_create_rundowns_table.php`) dan jalankan `php artisan migrate`.
3. [x] Buat Model `App\Models\KelolaUndangan\Rundown` dengan relasi `data()` dan `acara()`.
4. [x] Implementasi Sanitizer iframe Google Maps & Helper link di `Acara.php` & `acara.blade.php`.
5. [x] Implementasi Export CSV & Import Tamu CSV dengan template di `Tamu.php` & `tamu.blade.php`.
6. [x] Perbaiki preview image (tombol batal ganti, badge foto baru vs lama, frame rapi) di `pria.blade.php` & `wanita.blade.php`.
7. [x] Perbaiki visual badge posisi (#1, #2, dst.) dan tooltip tombol geser di `galery.blade.php`.
8. [x] Implementasi filter kategori tema interaktif di `Tema.php` & `tema.blade.php`.
9. [x] Implementasi Auto-generate Slug otomatis & unik di `Setting.php` & `setting.blade.php`.
10. [x] Perbaiki celah copy link (hilangkan window.alert browser) & integrasikan modul Rundown di `index.blade.php` & `Index.php`.
11. [x] Buat Livewire Component & View `Rundown.php` & `rundown.blade.php` + daftarkan route `/dashboard/kelola/{id}/rundown`.
12. [x] Perbaiki tag penutup ekstra `</div>` di `resources/views/components/ui/modal-delete.blade.php`.
13. [x] Buat Test Suite lengkap:
    - `RundownAcaraTest.php`: 6 tests, 15 assertions passed (100%).
    - `KelolaEnhancementsTest.php`: 6 tests, 14 assertions passed (100%).
    - `TamuRsvpUnifiedTest.php`: 7 tests, 27 assertions passed (100%).
    - `UrutanMempelaiTest.php`: 5 tests, 31 assertions passed (100%).
14. [x] Jalankan `npm run build` (Vite production bundle sukses, 0 error).
15. [x] Verifikasi live di browser via `browser_subagent` (seluruh form, filter kategori, toast clipboard, modal rundown, dan import/export berjalan mulus).
