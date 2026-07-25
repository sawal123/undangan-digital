<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $seen = [];

        DB::table('data')
            ->orderBy('id')
            ->select(['id', 'slug'])
            ->get()
            ->each(function ($row) use (&$seen) {
                $base = Str::slug($row->slug ?: 'undangan-'.$row->id) ?: 'undangan-'.$row->id;
                $slug = $base;
                $i = 2;

                while (isset($seen[$slug])) {
                    $slug = $base.'-'.$i++;
                }

                $seen[$slug] = true;

                if ($slug !== $row->slug) {
                    DB::table('data')->where('id', $row->id)->update(['slug' => $slug]);
                }
            });

        Schema::table('data', function (Blueprint $table) {
            $table->unique('slug', 'data_slug_unique');
        });

        DB::table('tamus')
            ->whereNull('kode')
            ->orWhere('kode', '')
            ->orderBy('id')
            ->select(['id', 'data_id'])
            ->get()
            ->each(function ($row) {
                DB::table('tamus')->where('id', $row->id)->update([
                    'kode' => $this->guestCode((int) $row->data_id),
                ]);
            });

        $guestCodes = [];
        DB::table('tamus')
            ->orderBy('id')
            ->select(['id', 'data_id', 'kode'])
            ->get()
            ->each(function ($row) use (&$guestCodes) {
                $key = $row->data_id.'|'.$row->kode;

                if (isset($guestCodes[$key])) {
                    DB::table('tamus')->where('id', $row->id)->update([
                        'kode' => $this->guestCode((int) $row->data_id),
                    ]);

                    return;
                }

                $guestCodes[$key] = true;
            });

        Schema::table('tamus', function (Blueprint $table) {
            $table->unique(['data_id', 'kode'], 'tamus_data_id_kode_unique');
        });
    }

    public function down(): void
    {
        Schema::table('tamus', function (Blueprint $table) {
            $table->dropUnique('tamus_data_id_kode_unique');
        });

        Schema::table('data', function (Blueprint $table) {
            $table->dropUnique('data_slug_unique');
        });
    }

    private function guestCode(int $dataId): string
    {
        do {
            $code = Str::lower(Str::random(12));
        } while (DB::table('tamus')->where('data_id', $dataId)->where('kode', $code)->exists());

        return $code;
    }
};
