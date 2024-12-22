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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->nullable();
            $table->foreignId('data_id')->constrained('data')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('link_snap')->nullable();
            $table->string('kode')->nullable();
            $table->string('price')->nullable();
            $table->string('promo')->nullable();
            $table->string('gross_amount')->nullable();
            $table->enum('payment_status',['SUCCESS', 'PENDING', 'CANCEL', 'FAILED', 'EXPIRED']);
            $table->string('payment_type')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
