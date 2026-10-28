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
        $birthdayEventTypeId = DB::table('event_types')->where('key', 'birthday')->value('id');
        $birthdayCategoryId = DB::table('categories')->where('category', 'Ulang Tahun')->value('id');

        if ($birthdayEventTypeId) {
            // Pastikan tema Quinceanera memiliki event_type_id Ulang Tahun
            DB::table('themes')
                ->where('path', 'tema.quinceanera')
                ->orWhere('nama', 'Quinceanera')
                ->update([
                    'event_type_id' => $birthdayEventTypeId,
                    'category_id' => $birthdayCategoryId ?: DB::raw('category_id'),
                    'updated_at' => now(),
                ]);
        }

        // Soft-delete tema Monster Party Birthday yang belum memiliki file view blade fisik
        DB::table('themes')
            ->where(function ($query) {
                $query->where('path', 'tema.monster-party-birthday')
                    ->orWhere('nama', 'like', '%Monster Party%');
            })
            ->whereNull('deleted_at')
            ->update([
                'deleted_at' => now(),
                'updated_at' => now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safe no-op agar tidak menghapus atau merusak data pengguna
    }
};
