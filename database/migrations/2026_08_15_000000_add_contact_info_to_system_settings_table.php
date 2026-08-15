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
        Schema::table('system_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('system_settings', 'whatsapp')) {
                $table->string('whatsapp', 30)->nullable()->after('twitter_card');
            }
            if (!Schema::hasColumn('system_settings', 'email')) {
                $table->string('email', 255)->nullable()->after('whatsapp');
            }
            if (!Schema::hasColumn('system_settings', 'address')) {
                $table->text('address')->nullable()->after('email');
            }
            if (!Schema::hasColumn('system_settings', 'instagram')) {
                $table->string('instagram', 255)->nullable()->after('address');
            }
            if (!Schema::hasColumn('system_settings', 'facebook')) {
                $table->string('facebook', 255)->nullable()->after('instagram');
            }
            if (!Schema::hasColumn('system_settings', 'tiktok')) {
                $table->string('tiktok', 255)->nullable()->after('facebook');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $columns = ['whatsapp', 'email', 'address', 'instagram', 'facebook', 'tiktok'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('system_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
