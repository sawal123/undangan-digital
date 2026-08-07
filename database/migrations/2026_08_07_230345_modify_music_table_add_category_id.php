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
        Schema::table('music', function (Blueprint $table) {
            // Drop old category string column
            if (Schema::hasColumn('music', 'category')) {
                $table->dropColumn('category');
            }

            // Add category_id foreign key
            $table->foreignId('category_id')->nullable()->after('artis')->constrained('categories')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('music', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');

            // Restore old category string column
            $table->string('category')->nullable()->after('artis');
        });
    }
};
