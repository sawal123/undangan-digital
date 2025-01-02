<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UndanganCetak extends Model
{
    use HasFactory;
    protected $fillable = ['nama',
    'jenis', 'stok', 'terjual',
    'harga', 'promo', 'favorite',
    'deskripsi', 'gambar'];
}
