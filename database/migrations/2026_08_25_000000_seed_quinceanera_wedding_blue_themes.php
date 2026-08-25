<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Daftarkan tema demo quinceanera & wedding_blue ke tabel themes
     * agar langsung muncul di sistem pemilihan tema setelah deploy.
     */
    public function up(): void
    {
        $this->registerTheme([
            'nama' => 'Quinceanera',
            'category' => 'Ulang Tahun',
            'event_type_key' => 'birthday',
            'path' => 'tema.quinceanera',
            'demo' => 'temademo.quinceanera',
        ]);

        $this->registerTheme([
            'nama' => 'Wedding Blue',
            'category' => 'Pernikahan',
            'event_type_key' => 'wedding',
            'path' => 'tema.wedding_blue',
            'demo' => 'temademo.wedding_blue',
        ]);
    }

    private function registerTheme(array $theme): void
    {
        // Jangan sentuh record existing yang masih aktif (mis. dibuat manual via
        // admin): insert hanya bila path tema belum terdaftar. Record yang
        // soft-deleted (deleted_at != null) dianggap tidak terdaftar agar tema
        // yang pernah dihapus tetap bisa didaftarkan ulang oleh migration.
        $existing = DB::table('themes')
            ->where('path', $theme['path'])
            ->whereNull('deleted_at')
            ->first();

        if ($existing) {
            return;
        }

        // Jika ada record soft-deleted dengan path sama, aktifkan kembali
        // (restore) agar id tema lama tetap dipakai dan data.theme_id aman.
        $softDeleted = DB::table('themes')
            ->where('path', $theme['path'])
            ->whereNotNull('deleted_at')
            ->first();

        if ($softDeleted) {
            DB::table('themes')
                ->where('id', $softDeleted->id)
                ->update([
                    'deleted_at' => null,
                    'updated_at' => now(),
                ]);

            return;
        }

        $eventTypeId = DB::table('event_types')->where('key', $theme['event_type_key'])->value('id');

        if (! $eventTypeId) {
            return;
        }

        $categoryId = DB::table('categories')->where('category', $theme['category'])->value('id');

        if (! $categoryId) {
            $categoryId = DB::table('categories')->insertGetId([
                'category' => $theme['category'],
                'icon' => $theme['event_type_key'] === 'birthday' ? 'cake' : 'heart',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('themes')->insert([
            'nama' => $theme['nama'],
            'category_id' => $categoryId,
            'event_type_id' => $eventTypeId,
            'path' => $theme['path'],
            'demo' => $theme['demo'],
            'thumbnail' => null,
            'deleted_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Rollback sengaja dibuat no-op (tidak destruktif).
     *
     * Theme adalah application data yang mungkin sudah digunakan oleh undangan
     * user atau sudah dibuat manual sebelum migration dijalankan. Menghapus
     * record themes pada down() berisiko merusak relasi data.theme_id dan
     * menghapus pilihan tema pengguna, jadi migrasi ini tidak menghapus apa pun.
     */
    public function down(): void
    {
        // no-op: jangan hapus themes, jangan ubah data.theme_id,
        // dan jangan menghapus category/event type.
    }
};
