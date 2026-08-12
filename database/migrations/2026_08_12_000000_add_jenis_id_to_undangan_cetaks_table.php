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
        if (Schema::hasTable('undangan_cetaks')) {
            Schema::table('undangan_cetaks', function (Blueprint $table) {
                if (!Schema::hasColumn('undangan_cetaks', 'jenis_id')) {
                    $table->foreignId('jenis_id')->nullable()->constrained('jenis_udangans')->onUpdate('cascade')->onDelete('restrict');
                }
                
                if (Schema::hasColumn('undangan_cetaks', 'jenis')) {
                    $table->dropColumn('jenis');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('undangan_cetaks')) {
            Schema::table('undangan_cetaks', function (Blueprint $table) {
                if (Schema::hasColumn('undangan_cetaks', 'jenis_id')) {
                    $table->dropForeign(['jenis_id']);
                    $table->dropColumn('jenis_id');
                }

                if (!Schema::hasColumn('undangan_cetaks', 'jenis')) {
                    $table->string('jenis')->nullable();
                }
            });
        }
    }
};
