<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisUdangan extends Model
{
    use HasFactory;
    protected $fillable = ['jenis'];

    public function undanganCetaks()
    {
        return $this->hasMany(UndanganCetak::class, 'jenis_id');
    }
}
