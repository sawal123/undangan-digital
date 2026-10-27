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
        Schema::table('data', function (Blueprint $table) {
            if (!Schema::hasColumn('data', 'urutan_mempelai')) {
                $table->string('urutan_mempelai', 20)->default('pria_wanita')->after('slug');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data', function (Blueprint $table) {
            if (Schema::hasColumn('data', 'urutan_mempelai')) {
                $table->dropColumn('urutan_mempelai');
            }
        });
    }
};
