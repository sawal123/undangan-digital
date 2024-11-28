<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teksWhatsApp extends Model
{
    use HasFactory;
    protected $fillable = ['data_id', 'pesan'];
    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
