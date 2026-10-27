# Plan Refactoring: Pusat Modul "Tamu & RSVP" dan Redesain Buku Tamu (QR Check-in)

**Tanggal:** 27 Oktober 2026  
**Status:** In Progress / Execution  
**Tujuan:** Mengintegrasikan pengelolaan Tamu, Konfirmasi Kehadiran (RSVP), dan Doa & Ucapan ke dalam 1 halaman pusat bertab yang intuitif, serta mentransformasikan modul Buku Tamu menjadi konsep QR Check-in Hari-H (*Coming Soon*).

---

## 1. Latar Belakang & Identifikasi Masalah

1. **Redundansi Data 100% Antara Ucapan dan Buku Tamu:**
   - Halaman `/dashboard/kelola/{id}/ucapan` dan `/dashboard/kelola/{id}/buku-tamu` mengakses model/tabel yang sama persis: `App\Models\KelolaUndangan\Ucapan`.
   - `Buku Tamu` hanya menampilkan 3 widget statistik kehadiran dan tabel ucapan *read-only*.
   - `Ucapan` menampilkan pengaturan switch on/off, daftar ucapan, dan form balasan.
   - Keberadaan dua halaman terpisah untuk hal yang sama membuat pengguna bingung.

2. **Pengalaman Pengguna yang Terfragmentasi (*Fragmented UX*):**
   - Pengantin menginput nama dan menyebar link di halaman **Tamu**.
   - Pengantin mengecek siapa yang konfirmasi hadir di halaman **Buku Tamu**.
   - Pengantin membaca dan membalas doa restu di halaman **Ucapan**.
   - Siklus manajemen tamu (*Guest Lifecycle*) terpecah ke 3 modul terpisah.

3. **Menu Bloat di Dashboard Kelola:**
   - Grid dashboard kelola memiliki 12 modul kartu, membuat navigasi padat dan tumpang tindih.

---

## 2. Solusi Arsitektur Baru

### A. 1 Halaman Pusat: "Tamu & RSVP" (`/dashboard/kelola/{id}/tamu`)
Menggabungkan ketiga fungsionalitas ke dalam 1 halaman Livewire modern berbasis **Tab Navigasi**:

1. **Tab 1: `daftar` (Daftar Tamu & Sebar Undangan)**
   - Form tambah/edit tamu (Nama, Nomor WhatsApp).
   - Generate link unik personal: `/u/{slug}/{kode}`.
   - Tombol Share WhatsApp langsung dengan format pesan otomatis.
   - Tombol Salin Link personal.
   - **Fitur Baru**: Badge status RSVP langsung di samping nama tamu (Hadir / Tidak Hadir / Belum Respon).

2. **Tab 2: `rsvp` (Rekap Kehadiran / RSVP)**
   - 4 Widget Statistik Interaktif:
     - Total Tamu Diundang
     - Konfirmasi Pasti Hadir
     - Konfirmasi Berhalangan
     - Belum Ada Respon
   - Filter tabel berdasarkan status kehadiran (*Semua*, *Hadir*, *Tidak Hadir*).
   - Rekap daftar kehadiran tamu beserta waktu konfirmasi.

3. **Tab 3: `ucapan` (Doa Restu & Ucapan)**
   - Kontrol pengaturan fitur:
     - *Aktifkan Form Ucapan* (on/off)
     - *Tampilkan Ucapan di Web Undangan* (on/off)
   - Kolom pencarian ucapan / nama tamu.
   - Kartu ucapan dengan kutipan pesan, waktu, status kehadiran, dan form balasan mempelai (`balas`).
   - Tombol hapus ucapan.

---

### B. Transformasi Buku Tamu: Digital Check-in & Scanner QR (*Coming Soon*)
- Mengubah fungsi `/dashboard/kelola/{id}/buku-tamu` menjadi antarmuka representatif untuk **Buku Tamu Digital Meja Resepsi Hari-H**.
- Menampilkan tampilan *Coming Soon* yang profesional, modern, dan informatif:
  - Penjelasan alur check-in tamu menggunakan QR Code saat tiba di venue.
  - Mockup fitur scanner QR, pencatatan amplop/angpao, dan pencatatan souvenir.
  - Edukasi pengguna mengenai perbedaan antara RSVP Online (sebelum acara) dengan Buku Tamu Digital (saat hari-H).

---

### C. Penyesuaian Menu Dashboard (`Kelola/Index.php`)
- Mengubah modul `Tamu` menjadi:
  `['nama' => 'Tamu & RSVP', 'icon' => 'users', 'url' => 'tamu', 'desc' => 'Daftar tamu, RSVP & ucapan']`
- Mengubah modul `Buku Tamu` menjadi:
  `['nama' => 'Buku Tamu QR', 'icon' => 'qr-code', 'url' => 'buku-tamu', 'desc' => 'Scan kehadiran hari-H (Segera Hadir)']`
- Menghilangkan redundansi modul `Ucapan` dari grid menu utama kelola, namun route `/kelola/{id}/ucapan` tetap diarahkan dengan aman (*redirect* ke `/kelola/{id}/tamu?tab=ucapan`) agar tidak terjadi link rusak (*backward compatibility*).

---

## 3. Rencana Langkah Eksekusi (Action Items)

1. [x] Analisis mendalam kode dan model database existing.
2. [x] Buat dokumen `docs/PLAN_REFACTOR_TAMU_RSVP.md`.
3. [ ] Update Livewire Component `app/Livewire/DashboardDemo/Kelola/Tamu.php`:
   - Tambahkan state `$activeTab` (`'daftar'`, `'rsvp'`, `'ucapan'`).
   - Integrasikan fitur load & update `FiturUcapan` (toggle on/off).
   - Integrasikan fitur load & balas `Ucapan`, serta hapus ucapan.
   - Tambahkan relasi eager load `ucapans` pada daftar tamu untuk menampilkan badge status RSVP.
   - Tambahkan perhitungan statistik kehadiran (Hadir, Tidak Hadir, Total Tamu, Belum Respon).
4. [ ] Update Blade View `resources/views/livewire/dashboard/kelola/tamu.blade.php`:
   - Tambahkan Tab Header modern (*Daftar Tamu*, *Rekap Kehadiran (RSVP)*, *Doa & Ucapan*).
   - Render Tab 1 (Daftar Tamu + Status RSVP + Sebar WA + Modal Add/Edit Tamu + Modal Share).
   - Render Tab 2 (Statistik Kehadiran 4 Kolom + Tabel Rekap Kehadiran & Filter).
   - Render Tab 3 (Switch Pengaturan Ucapan + Search + List Card Ucapan & Form Balas).
5. [ ] Update Livewire Component `app/Livewire/DashboardDemo/Kelola/Ucapan.php`:
   - Berikan redirect ke `route('dashboard.undangan.tamu', ['id' => $id, 'tab' => 'ucapan'])` agar bookmark atau link lama tetap aman.
6. [ ] Update Blade View `resources/views/livewire/dashboard/kelola/buku-tamu.blade.php`:
   - Ubah menjadi tampilan profesional "Buku Tamu Digital & QR Check-in (Segera Hadir / Coming Soon)".
7. [ ] Update Menu Grid di `app/Livewire/DashboardDemo/Kelola/Index.php`:
   - Ringkas daftar menu kartu (menggabungkan Tamu & RSVP, merapikan Buku Tamu QR).
8. [ ] Jalankan `npm run build` untuk kompilasi CSS Tailwind terbaru.
9. [ ] Jalankan automated feature tests PHPUnit untuk memverifikasi fungsionalitas dan mencegah regresi.
10. [ ] Lakukan verifikasi visual dan dokumentasi hasil.
