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
        // Jangan sentuh record yang sudah ada (mis. dibuat manual via admin):
        // insert hanya bila path tema belum terdaftar.
        if (DB::table('themes')->where('path', $theme['path'])->exists()) {
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

    public function down(): void
    {
        $themeIds = DB::table('themes')
            ->whereIn('path', ['tema.quinceanera', 'tema.wedding_blue'])
            ->pluck('id');

        if ($themeIds->isEmpty()) {
            return;
        }

        // Lepas relasi data.theme_id dulu (FK ber-onDelete cascade):
        // menghapus theme tanpa ini akan ikut menghapus undangan user.
        DB::table('data')
            ->whereIn('theme_id', $themeIds)
            ->update(['theme_id' => null]);

        DB::table('themes')->whereIn('id', $themeIds)->delete();
    }
};
