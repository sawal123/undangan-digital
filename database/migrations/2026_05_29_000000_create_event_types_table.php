<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::table('event_types')->insert([
            [
                'name' => 'Pernikahan',
                'key' => 'wedding',
                'description' => 'Undangan akad, resepsi, dan rangkaian acara pernikahan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ulang Tahun',
                'key' => 'birthday',
                'description' => 'Undangan ulang tahun anak, dewasa, atau sweet seventeen.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tunangan',
                'key' => 'engagement',
                'description' => 'Undangan lamaran atau pertunangan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pengajian',
                'key' => 'pengajian',
                'description' => 'Undangan pengajian, tasyakuran, atau kajian.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Event',
                'key' => 'event',
                'description' => 'Undangan seminar, gathering, launching, dan event umum.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Schema::table('themes', function (Blueprint $table) {
            $table->foreignId('event_type_id')
                ->nullable()
                ->after('category_id')
                ->constrained('event_types')
                ->nullOnDelete();
        });

        Schema::table('data', function (Blueprint $table) {
            $table->foreignId('event_type_id')
                ->nullable()
                ->after('theme_id')
                ->constrained('event_types')
                ->nullOnDelete();
        });

        $weddingId = DB::table('event_types')->where('key', 'wedding')->value('id');

        DB::table('themes')->whereNull('event_type_id')->update(['event_type_id' => $weddingId]);
        DB::table('data')->whereNull('event_type_id')->update(['event_type_id' => $weddingId]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data', function (Blueprint $table) {
            $table->dropConstrainedForeignId('event_type_id');
        });

        Schema::table('themes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('event_type_id');
        });

        Schema::dropIfExists('event_types');
    }
};
