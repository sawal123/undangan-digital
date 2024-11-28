<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teksPenutup extends Model
{
    use HasFactory;
    protected $fillable = ['data_id', 'hormat_kami', 'mengundang'];
    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
