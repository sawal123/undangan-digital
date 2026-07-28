<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UndanganCetak extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis',
        'stok',
        'terjual',
        'harga',
        'harga_modal',
        'ukuran_opp',
        'promo',
        'favorite',
        'deskripsi',
        'gambar',
    ];

    protected $casts = [
        'gambar' => 'array',
        'harga' => 'integer',
        'promo' => 'integer',
    ];

    /**
     * Get primary thumbnail URL with safe fallback.
     */
    public function getThumbnailUrlAttribute(): string
    {
        $defaultUrl = asset('images/default-invitation.png');

        if (empty($this->gambar)) {
            return $defaultUrl;
        }

        $decoded = is_array($this->gambar) ? $this->gambar : (json_decode($this->gambar, true) ?: []);

        if (!is_array($decoded) || empty($decoded)) {
            return $defaultUrl;
        }

        $first = $decoded[0] ?? null;
        if (!$first || !is_string($first)) {
            return $defaultUrl;
        }

        if (str_starts_with($first, 'http://') || str_starts_with($first, 'https://')) {
            return $first;
        }

        $cleanPath = ltrim($first, '/');
        if (str_starts_with($cleanPath, 'public/')) {
            $cleanPath = substr($cleanPath, 7);
        }
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }

        if (Storage::disk('public')->exists($cleanPath)) {
            return asset('storage/' . $cleanPath);
        }

        return $defaultUrl;
    }

    /**
     * Get all image URLs array with safe fallback.
     */
    public function getImageUrlsAttribute(): array
    {
        $defaultUrl = asset('images/default-invitation.png');

        if (empty($this->gambar)) {
            return [$defaultUrl];
        }

        $decoded = is_array($this->gambar) ? $this->gambar : (json_decode($this->gambar, true) ?: []);

        if (!is_array($decoded) || empty($decoded)) {
            return [$defaultUrl];
        }

        $urls = [];
        foreach ($decoded as $item) {
            if (!is_string($item) || empty($item)) continue;

            if (str_starts_with($item, 'http://') || str_starts_with($item, 'https://')) {
                $urls[] = $item;
                continue;
            }

            $cleanPath = ltrim($item, '/');
            if (str_starts_with($cleanPath, 'public/')) {
                $cleanPath = substr($cleanPath, 7);
            }
            if (str_starts_with($cleanPath, 'storage/')) {
                $cleanPath = substr($cleanPath, 8);
            }

            if (Storage::disk('public')->exists($cleanPath)) {
                $urls[] = asset('storage/' . $cleanPath);
            }
        }

        return !empty($urls) ? $urls : [$defaultUrl];
    }
}
