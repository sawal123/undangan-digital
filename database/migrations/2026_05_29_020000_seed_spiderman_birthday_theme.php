<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $birthdayId = DB::table('event_types')->where('key', 'birthday')->value('id');

        if (! $birthdayId) {
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

        DB::table('themes')->updateOrInsert(
            ['path' => 'tema.spiderman.ultah-induk'],
            [
                'nama' => 'Spiderman Birthday',
                'category_id' => $categoryId,
                'event_type_id' => $birthdayId,
                'demo' => 'temademo.spiderman',
                'thumbnail' => null,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('themes')->where('path', 'tema.spiderman.ultah-induk')->delete();
    }
};
