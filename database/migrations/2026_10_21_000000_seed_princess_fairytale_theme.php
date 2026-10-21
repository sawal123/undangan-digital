<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('themes')->where('path', 'tema.princess-fairytale')->whereNull('deleted_at')->exists()) {
            return;
        }

        $softDeleted = DB::table('themes')
            ->where('path', 'tema.princess-fairytale')
            ->whereNotNull('deleted_at')
            ->first();

        if ($softDeleted) {
            DB::table('themes')->where('id', $softDeleted->id)->update([
                'deleted_at' => null,
                'updated_at' => now(),
            ]);

            return;
        }

        $eventTypeId = DB::table('event_types')->where('key', 'birthday')->value('id');

        if (! $eventTypeId) {
            return;
        }

        $categoryId = DB::table('categories')->where('category', 'Ulang Tahun')->value('id');

        if (! $categoryId) {
            $categoryId = DB::table('categories')->insertGetId([
                'category' => 'Ulang Tahun',
                'icon' => 'cake',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('themes')->insert([
            'nama' => 'Princess Fairytale',
            'category_id' => $categoryId,
            'event_type_id' => $eventTypeId,
            'path' => 'tema.princess-fairytale',
            'demo' => 'temademo.princess-fairytale',
            'thumbnail' => null,
            'deleted_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // No-op: theme records may already be used by invitations.
    }
};
