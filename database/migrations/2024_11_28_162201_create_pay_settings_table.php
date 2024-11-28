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
        Schema::create('pay_settings', function (Blueprint $table) {
            $table->id();
            $table->string('bank');
            $table->string('category');
            $table->bigInteger('fee');
            $table->string('image');
            $table->text('deskripsi')->nullable();
            $table->boolean('isActive')->nullable()->default(true);
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_settings');
    }
};
