<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $theme = [
            'nama' => 'Celebrate',
            'category' => 'Nikah',
            'event_type_key' => 'wedding',
            'path' => 'tema.celebrate',
            'demo' => 'temademo.celebrate',
            'thumbnail' => 'tema/celebrate/assets/images/couple-hero.webp',
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
            ->value('id') ?? 1;

        $categoryId = DB::table('categories')
            ->where('category', $theme['category'])
            ->value('id') ?? 1;

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
            ->where('path', 'tema.celebrate')
            ->delete();
    }
};
