<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $theme = [
            'nama' => 'Astronot',
            'category' => 'Ulang Tahun',
            'event_type_key' => 'birthday',
            'path' => 'tema.astronot',
            'demo' => 'temademo.astronot',
            'thumbnail' => 'tema/astronot/assets/images/captain-avatar.webp',
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
            ->value('id') ?? 2;

        $categoryId = DB::table('categories')
            ->where('category', $theme['category'])
            ->value('id') ?? 2;

        DB::table('themes')->insert([
            'nama' => $theme['nama'],
            'category_id' => $categoryId,
            'event_type_id' => $eventTypeId,
            'path' => $theme['path'],
            'demo' => $theme['demo'],
            'thumbnail' => $theme['thumbnail'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('themes')
            ->where('path', 'tema.astronot')
            ->delete();
    }
};
