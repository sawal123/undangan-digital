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
        Schema::create('data_fonts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_id');
            $table->foreign('data_id')->references('id')->on('data')->onDelete('cascade');

            $table->unsignedBigInteger('f_title')->nullable();
            $table->foreign('f_title')->references('id')->on('fonts')->onDelete('set null');

            $table->unsignedBigInteger('f_sub')->nullable();
            $table->foreign('f_sub')->references('id')->on('fonts')->onDelete('set null');

            $table->integer('s_title')->default(32); // px
            $table->integer('s_sub')->default(16);   // px
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_fonts');
    }
};
