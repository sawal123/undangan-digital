<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $theme = [
            'nama' => 'Dino Jungle',
            'category' => 'Ulang Tahun',
            'event_type_key' => 'birthday',
            'path' => 'tema.dino-jungle',
            'demo' => 'temademo.dino-jungle',
        ];

        $existing = DB::table('themes')
            ->where('path', $theme['path'])
            ->whereNull('deleted_at')
            ->first();

        if ($existing) {
            return;
        }

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

        $eventTypeId = DB::table('event_types')
            ->where('key', $theme['event_type_key'])
            ->value('id');

        if (! $eventTypeId) {
            return;
        }

        $categoryId = DB::table('categories')
            ->where('category', $theme['category'])
            ->value('id');

        if (! $categoryId) {
            $categoryId = DB::table('categories')->insertGetId([
                'category' => $theme['category'],
                'icon' => 'cake',
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
        // No-op agar rollback tidak menghapus tema yang mungkin sudah dipakai.
    }
};
