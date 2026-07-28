<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Theme extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nama', 'category_id', 'event_type_id', 'path', 'demo', 'thumbnail'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function eventType()
    {
        return $this->belongsTo(EventType::class);
    }

    public function data()
    {
        return $this->hasOne(Data::class);
    }

    /**
     * Get primary thumbnail URL with safe fallback.
     */
    public function getThumbnailUrlAttribute(): string
    {
        $defaultUrl = asset('images/default-invitation.png');

        if (empty($this->thumbnail) || !is_string($this->thumbnail)) {
            return $defaultUrl;
        }

        $path = trim($this->thumbnail);

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

        return $defaultUrl;
    }
}
