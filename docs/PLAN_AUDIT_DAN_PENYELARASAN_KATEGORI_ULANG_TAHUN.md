# Plan Audit dan Penyelarasan Fitur Kelola Kategori Ulang Tahun

## 1. Latar Belakang & Tujuan
Saat pengguna memilih kategori **Ulang Tahun** (`event_type_id = 2` / `key = 'birthday'`), sistem diharapkan menyajikan alur kelola yang sepenuhnya relevan untuk acara ulang tahun, bukan mengasumsikan acara pernikahan.
Berdasarkan hasil audit engineering, ditemukan beberapa celah data, inkonsistensi tema, seeding pernikahan pada acara ulang tahun, serta copy/placeholder yang masih berorientasi nikah pada modul kelola.

Tujuan dokumen ini adalah menetapkan langkah-langkah konkret untuk menyelaraskan alur kategori ulang tahun secara menyeluruh tanpa merusak alur pernikahan yang sudah ada.

---

## 2. Temuan Audit Utama

1. **Inkonsistensi Database Tema**:
   - Tema `Quinceanera` (ID 11) memiliki `category_id = 2` (Ulang Tahun) tetapi `event_type_id = 1` (Pernikahan). Akibatnya tema ini tidak bisa dilihat atau dipilih oleh pengguna undangan ulang tahun.
   - Tema `Monster Party Birthday` (ID 14) terdaftar di database tetapi file view blade fisiknya tidak ada (`tema.monster-party-birthday`), yang dapat menyebabkan crash jika dipilih.
2. **Seeding Undangan Baru Menggunakan Kutipan Nikah**:
   - Di `DataController::store`, saat undangan ulang tahun dibuat, quote yang di-seed masih berupa QS. Ar-Rum: 21 (tentang suami & istri).
   - Template WhatsApp default untuk ulang tahun belum menyertakan variabel nama anak/yang berulang tahun secara optimal.
3. **Komponen Rundown Belum Masuk ke Tema Ulang Tahun**:
   - Tema `princess-fairytale.blade.php` dan `dino-jungle.blade.php` belum memuat section rundown acara, sehingga data rundown yang diisi di dashboard tidak tampil.
4. **Modul Pengaturan & Setting**:
   - `Setting::generateSlug()` hanya mengecek `couple_name` (mempelai pria & wanita), sehingga pada ulang tahun slug otomatis jatuh ke fallback umum bukan nama anak.
   - Panduan tag template WhatsApp di `setting.blade.php` hanya mencantumkan `@{{nama_mempelai1}}` dan `@{{nama_mempelai2}}`.
   - Placeholder kata mutiara di `setting.blade.php` terkunci ke "QS. Ar-Rum: 21".
5. **Wording & Placeholder Nikah di Modul Acara & Rundown**:
   - `acara.blade.php`: Placeholder form modal masih bertuliskan "Contoh: Akad Nikah" dan "Contoh: Kediaman Mempelai".
   - `rundown.blade.php`: Empty state dan placeholder modal masih bertuliskan "Akad Nikah, Temu Manten...".
6. **Pemilihan Tema (`Tema.php`)**:
   - Filter tab kategori default ke `all`. Untuk undangan ulang tahun, seharusnya tab otomatis aktif ke kategori "Ulang Tahun".
7. **Penyempurnaan Modul Profil Ulang Tahun (`Birthday.php` & `birthday.blade.php`)**:
   - Penambahan UI preview foto yang konsisten (tombol batal/reset ✕ serta badge pembeda `Foto Baru` vs `Foto Saat Ini`).
8. **Proteksi Route Kelola**:
   - Route `pengantin`, `kisah-cinta`, dan `streaming` diarahkan (redirect) ke hub jika undangan bertipe non-nikah (ulang tahun).

---

## 3. Rencana Eksekusi Bertahap

### Fase 1: Perbaikan Data Tema & Migration
- Buat migration:
  - Update `themes` yang beralamat `tema.quinceanera` agar memiliki `event_type_id = 2` (sesuai event type `birthday`).
  - Soft-delete tema yang tidak memiliki view fisik (`tema.monster-party-birthday`).
- Integrasi rundown section ke tema:
  - `resources/views/tema/princess-fairytale.blade.php` (tambahkan section rundown setelah jadwal acara).
  - `resources/views/tema/dino-jungle.blade.php` (tambahkan section rundown setelah jadwal acara).

### Fase 2: Perbaikan Seeding & Pembuatan Undangan (`DataController.php`)
- Sesuaikan `DataController::store`:
  - Jika `eventKey === 'birthday'`, seed quote doa keberkahan usia:
    - Title: `بَارَكَ اللَّهُ لَكَ فِي عُمْرِكَ`
    - Quote: "Semoga Allah memberkahi umurmu, melimpahkan kesehatan, kebahagiaan, serta menjadikanmu insan yang bertakwa dan berbakti kepada orang tua."
    - Subtitle: "Doa & Berkah Usia"
  - Perkaya default template WhatsApp ulang tahun agar menyertakan `*{{nama_ulang_tahun}}* (ke-{{usia}})`.

### Fase 3: Penyelarasan Modul Setting & Auto-Slug (`Setting.php` & `setting.blade.php`)
- Pada `Setting::generateSlug()`:
  - Cek apakah relasi `birthdayProfile` terisi. Jika ada, jadikan nama/panggilan sebagai basis slug: `Str::slug($data->birthdayProfile->nickname ?: $data->birthdayProfile->name)`.
- Pada `setting.blade.php`:
  - Perbarui bantuan tag WhatsApp untuk menampilkan `@{{nama_ulang_tahun}}`, `@{{usia}}`, `@{{penyelenggara}}`.
  - Buat placeholder quote dinamis jika acara adalah ulang tahun.

### Fase 4: Penyelarasan Modul Acara & Rundown (`Acara` & `Rundown`)
- Pada `Acara.php` & `acara.blade.php`:
  - Deteksi tipe event undangan.
  - Tampilkan placeholder dinamis: "Contoh: Pesta Ulang Tahun / Tiup Lilin" & "Contoh: Rumah / Resto / Cafe".
- Pada `Rundown.php` & `rundown.blade.php`:
  - Tampilkan empty state dinamis untuk ulang tahun ("Tambahkan susunan acara seperti Pembukaan, Games, Tiup Lilin, Potong Kue, Foto Bersama").
  - Placeholder modal kegiatan adaptif untuk ulang tahun.

### Fase 5: Filter Kategori Tema Otomatis & Proteksi Route
- Pada `Tema.php`:
  - Saat `mount()`, jika tipe event adalah `birthday`, default-kan `selectedCategory` ke ID kategori "Ulang Tahun".
- Pada `Pengantin.php`, `Kisah.php`, `Streaming.php`:
  - Tambahkan guard: jika event type adalah `birthday`, alihkan kembali ke halaman kelola hub undangan.
- Pada `Birthday.php`:
  - Tambahkan guard: jika event type bukan `birthday`, alihkan kembali ke hub.
  - Perbaiki UI preview upload foto di `birthday.blade.php` dengan badge status foto dan tombol cancel ✕.

### Fase 6: Auto-Generate Slug pada Halaman /setup & /add-undangan
- Pada `checkName.js`:
  - Saat input `#title` ("Nama Yang Ingin Ditampilkan") diketik, otomatis lakukan generate slug ke `#basic-url` ("Your vanity URL").
  - Berikan fungsi `slugify()` yang bersih (lowercase, konversi `&` menjadi `dan`, spasi menjadi strip `-`).
  - Lakukan validasi AJAX ketersediaan slug secara debounced (250ms).
  - Jika pengguna mengedit `#basic-url` secara manual, pertahankan input manual pengguna; jika dikosongkan, kembali otomatis sinkron dengan `#title`.
  - Sesuaikan placeholder dan teks contoh ("Contoh: ...") secara dinamis saat dropdown jenis undangan dipilih (misal: "Arash Nayaka" atau "Keisha 7th" untuk Ulang Tahun).

---

## 4. Validasi & Pengujian
- Unit & Feature test:
  - Uji pembuatan undangan ulang tahun via `DataController::store` (verifikasi quote doa usia dan template WhatsApp).
  - Uji `generateSlug()` dengan `birthdayProfile`.
  - Uji filter kategori tema otomatis untuk ulang tahun dan ketersediaan tema Quinceanera.
  - Uji render tema ulang tahun (`princess-fairytale`, `dino-jungle`, `spiderman`, `quinceanera`) dengan rundown aktif.
  - Uji route guard pengantin/kisah/streaming vs birthday.
  - Uji ketersediaan slug pada endpoint `/check-name`.
