<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rundowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_id')->constrained('data')->cascadeOnDelete();
            $table->foreignId('acara_id')->nullable()->constrained('acaras')->nullOnDelete();
            $table->string('waktu_mulai', 50);
            $table->string('waktu_selesai', 50)->nullable();
            $table->string('nama_kegiatan');
            $table->text('keterangan')->nullable();
            $table->string('lokasi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort')->default(1);
            $table->timestamps();

            $table->index(['data_id', 'sort']);
            $table->index(['data_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rundowns');
    }
};
