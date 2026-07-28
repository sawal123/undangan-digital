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
        Schema::table('undangan_cetaks', function (Blueprint $table) {
            $table->decimal('harga_modal', 12, 2)->default(0)->after('harga');
            $table->string('ukuran_opp', 50)->nullable()->after('harga_modal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('undangan_cetaks', function (Blueprint $table) {
            $table->dropColumn(['harga_modal', 'ukuran_opp']);
        });
    }
};
