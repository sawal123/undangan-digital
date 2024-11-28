<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coverUndangan extends Model
{
    use HasFactory;
    protected $fillable = ['data_id', 'cover_satu', 'cover_dua'];
    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
