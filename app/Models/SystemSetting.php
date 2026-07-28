<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_name',
        'logo',
        'logo_dark',
        'favicon',
        'apple_touch_icon',
        'seo_title',
        'seo_keywords',
        'seo_description',
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

    protected $casts = [
        'seo_robots_index' => 'boolean',
        'seo_robots_follow' => 'boolean',
    ];

    /**
     * Singleton accessor with permanent caching and safe fallback for tests/migrations.
     */
    public static function current(): self
    {
        return Cache::rememberForever('system_settings.main', function () {
            try {
                if (!Schema::hasTable('system_settings')) {
                    return self::makeFallbackInstance();
                }

                $setting = self::first();
                if (!$setting) {
                    $setting = self::create([
                        'app_name' => 'WayaeNikah',
                        'seo_title' => 'WayaeNikah - Undangan Digital & Cetak Fisik Premium',
                        'seo_description' => 'Platform pembuatan undangan digital & undangan cetak fisik premium dengan beragam pilihan desain elegan, fitur lengkap, dan responsif.',
                        'seo_keywords' => 'undangan digital, undangan pernikahan, undangan cetak, wayaenikah, tema undangan',
                        'seo_robots_index' => true,
                        'seo_robots_follow' => true,
                        'twitter_card' => 'summary_large_image',
                    ]);
                }
                return $setting;
            } catch (\Throwable $e) {
                return self::makeFallbackInstance();
            }
        });
    }

    protected static function makeFallbackInstance(): self
    {
        return new self([
            'app_name' => 'WayaeNikah',
            'seo_title' => 'WayaeNikah - Undangan Digital & Cetak Fisik Premium',
            'seo_description' => 'Platform pembuatan undangan digital & undangan cetak fisik premium dengan beragam pilihan desain elegan, fitur lengkap, dan responsif.',
            'seo_keywords' => 'undangan digital, undangan pernikahan, undangan cetak, wayaenikah',
            'seo_robots_index' => true,
            'seo_robots_follow' => true,
            'twitter_card' => 'summary_large_image',
        ]);
    }

    /**
     * Helper to resolve file URLs safely.
     */
    protected function resolveUrl(?string $path, ?string $fallback = null): ?string
    {
        if (empty($path) || !is_string($path)) {
            return $fallback;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');
        if (str_starts_with($cleanPath, 'public/')) {
            $cleanPath = substr($cleanPath, 7);
        }
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }

        if (Storage::disk('public')->exists($cleanPath)) {
            return asset('storage/' . $cleanPath);
        }

        return $fallback;
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->resolveUrl($this->logo);
    }

    public function getLogoDarkUrlAttribute(): ?string
    {
        return $this->resolveUrl($this->logo_dark, $this->logo_url);
    }

    public function getFaviconUrlAttribute(): string
    {
        return $this->resolveUrl($this->favicon, asset('favicon.ico'));
    }

    public function getAppleTouchIconUrlAttribute(): ?string
    {
        return $this->resolveUrl($this->apple_touch_icon, $this->favicon_url);
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->resolveUrl($this->og_image, asset('images/default-invitation.png'));
    }

    public function getTwitterImageUrlAttribute(): ?string
    {
        return $this->resolveUrl($this->twitter_image, $this->og_image_url);
    }
}
