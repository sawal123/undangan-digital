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
        Schema::create('sosial_media', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wanita_id')->nullable();
            $table->unsignedBigInteger('pria_id')->nullable();
            $table->foreign('wanita_id')->references('id')->on('wanitas')->onDelete('set null');
            $table->foreign('pria_id')->references('id')->on('prias')->onDelete('set null');
            $table->unsignedBigInteger('sosmed_id')->nullable();
            $table->foreign('sosmed_id')->references('id')->on('sosmeds')->onDelete('set null');
            $table->string('nama');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sosial_media');
    }
};
