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
            if (!Schema::hasColumn('system_settings', 'logo_dark')) {
                $table->string('logo_dark')->nullable()->after('logo');
            }
            if (!Schema::hasColumn('system_settings', 'apple_touch_icon')) {
                $table->string('apple_touch_icon')->nullable()->after('favicon');
            }
            if (!Schema::hasColumn('system_settings', 'seo_author')) {
                $table->string('seo_author')->nullable()->after('seo_title');
            }
            if (!Schema::hasColumn('system_settings', 'seo_robots_index')) {
                $table->boolean('seo_robots_index')->default(true)->after('seo_description');
            }
            if (!Schema::hasColumn('system_settings', 'seo_robots_follow')) {
                $table->boolean('seo_robots_follow')->default(true)->after('seo_robots_index');
            }
            if (!Schema::hasColumn('system_settings', 'google_site_verification')) {
                $table->string('google_site_verification')->nullable()->after('seo_robots_follow');
            }
            if (!Schema::hasColumn('system_settings', 'og_title')) {
                $table->string('og_title')->nullable()->after('google_site_verification');
            }
            if (!Schema::hasColumn('system_settings', 'og_description')) {
                $table->text('og_description')->nullable()->after('og_title');
            }
            if (!Schema::hasColumn('system_settings', 'og_image')) {
                $table->string('og_image')->nullable()->after('og_description');
            }
            if (!Schema::hasColumn('system_settings', 'twitter_title')) {
                $table->string('twitter_title')->nullable()->after('og_image');
            }
            if (!Schema::hasColumn('system_settings', 'twitter_description')) {
                $table->text('twitter_description')->nullable()->after('twitter_title');
            }
            if (!Schema::hasColumn('system_settings', 'twitter_image')) {
                $table->string('twitter_image')->nullable()->after('twitter_description');
            }
            if (!Schema::hasColumn('system_settings', 'twitter_card')) {
                $table->string('twitter_card')->default('summary_large_image')->after('twitter_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $columns = [
                'logo_dark',
                'apple_touch_icon',
                'seo_author',
                'seo_robots_index',
                'seo_robots_follow',
                'google_site_verification',
                'og_title',
                'og_description',
                'og_image',
                'twitter_title',
                'twitter_description',
                'twitter_image',
                'twitter_card',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('system_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
