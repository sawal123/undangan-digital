# Plan & Dokumentasi: Fitur Urutan Tampilan Mempelai (Couple Display Order)

**Branch:** `feature/unified-tamu-and-bride-order`  
**Tanggal:** 27 Oktober 2026  
**Status:** In Progress / Execution  

---

## 1. Latar Belakang & Identifikasi Masalah

* **Masalah:** Di berbagai adat pernikahan di Indonesia (seperti adat Padang/Minang, adat keluarga wanita yang mengadakan hajat utama, dsb.), nama dan profil **Mempelai Wanita** harus ditampilkan di posisi pertama (*Lady First*, misal *"Putri & Jimmi"*).
* **Kondisi Eksisting:** Sistem sebelumnya mengunci posisi pria selalu pertama. Solusi darurat sebelumnya adalah menyuruh user mengisi data wanita di kolom pria dan sebaliknya.
* **Mengapa Menukar Input adalah "Bom Waktu" (*Technical Debt*):**
  1. **Data Semantik Rusak:** Data wanita tersimpan di tabel `prias` dan sebaliknya.
  2. **Label Bawaan Tertukar:** Label tema *"The Groom / Putra dari..."* tampil di atas foto wanita bergaun/hijab.
  3. **Integrasi WhatsApp & SEO Rusak:** Template pesan dan metadata media sosial menjadi terbalik dan janggal.
  4. **Pengguna Terjebak:** Jika ingin mengembalikan urutan atau ganti tema, seluruh data harus dihapus dan diketik ulang.

---

## 2. Arsitektur Solusi

### Prinsip Utama
> **Pemisahan Tegas antara Data Semantik (*Storage*) dan Tata Letak (*Presentation Logic*).**  
> Data pria tetap tersimpan di entitas Pria (`prias`), data wanita tetap di entitas Wanita (`wanitas`). Urutan tampilan dikontrol oleh konfigurasi sistem.

### A. Database Layer
Menambahkan kolom `urutan_mempelai` pada tabel `data`:
- Nilai: `'pria_wanita'` *(Default, Pria & Wanita, contoh: Jimmi & Putri)*
- Nilai: `'wanita_pria'` *(Wanita & Pria, contoh: Putri & Jimmi)*

### B. Model Layer (`App\Models\Data.php`)
Menyediakan helper terpusat (*Single Source of Truth*):
- `$data->is_wanita_first` (Boolean): Mengecek apakah user memilih wanita di depan.
- `$data->couple_name` (String): Menghasilkan nama pasangan sesuai urutan (contoh: *"Putri & Jimmi"* atau *"Jimmi & Putri"*).
- `$data->first_person` & `$data->second_person`: Mengembalikan objek mempelai pertama dan kedua beserta metadata label yang tepat (*"Mempelai Wanita / Putri dari"* vs *"Mempelai Pria / Putra dari"*).

### C. Dashboard Pengantin (`Pengantin.php` & `pengantin.blade.php`)
- Menyediakan selector interaktif di bagian atas:
  - Radio Card Pilihan:
    - 🔘 **Pria di Depan (Jimmi & Putri)**
    - 🔘 **Wanita di Depan (Putri & Jimmi)**
- **Reordering Visual Kartu Input:**
  - Jika user memilih "Wanita di Depan", kartu input *Data Mempelai Wanita* otomatis berpindah ke sisi kiri/atas, dan kartu *Data Mempelai Pria* berpindah ke sisi kanan/bawah.
  - Form input tetap semantik: Pria diisi data pria, Wanita diisi data wanita.

### D. Controller Layer (`app/Http/Controllers/TemaController.php`)
- Pada fungsi `prepareInvitationData()`, kirimkan variabel penolong:
  - `'coupleNames' => $data->couple_name`
  - `'isWanitaFirst' => $data->is_wanita_first`
  - `'firstPerson' => $data->first_person`
  - `'secondPerson' => $data->second_person`

### E. Theme Layer (10 Tema Pernikahan)
Menyesuaikan titik tampil nama pasangan dan section profil pada 10 tema pernikahan:
1. `wedding_blue`
2. `deepone`
3. `deepone-pink`
4. `logangold`
5. `mahligai`
6. `flowerone`
7. `whitepre`
8. `darkpre`
9. `darksweet`
10. `standtheme`

---

## 3. Rencana Langkah Eksekusi

1. [x] Buat git branch `feature/unified-tamu-and-bride-order` dan commit pembaruan sebelumnya.
2. [x] Buat dokumen `docs/PLAN_URUTAN_MEMPELAI.md`.
3. [x] Buat dan jalankan database migration untuk menambahkan kolom `urutan_mempelai` pada tabel `data`.
4. [x] Perbarui model `App\Models\Data.php` dengan fillable dan helper accessors (`couple_name`, `is_wanita_first`, `first_person`, `second_person`).
5. [x] Update Livewire Component `app/Livewire/DashboardDemo/Kelola/Pengantin.php` dan View `pengantin.blade.php` dengan switcher interaktif & visual reordering.
6. [x] Update `app/Http/Controllers/TemaController.php` dan `InvitationMessageRenderer.php`.
7. [x] Sesuaikan 10 tema pernikahan (`wedding_blue`, `deepone`, `deepone-pink`, `logangold`, `mahligai`, `flowerone`, `whitepre`, `darkpre`, `darksweet`, `standtheme`) agar urutan nama dan profil mempelai dinamis.
8. [x] Buat Feature Test `tests/Feature/UrutanMempelaiTest.php` (5 test passed, 23 assertions).
9. [x] Jalankan testing menyeluruh dan `npm run build`.
10. [x] Commit seluruh hasil akhir ke branch `feature/unified-tamu-and-bride-order`.
