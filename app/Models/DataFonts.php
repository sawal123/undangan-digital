<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataFonts extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_id',
        'f_title',
        'f_sub',
        's_title',
        's_sub'
    ];
    public function data()
    {
        return $this->belongsTo(Data::class);
    }

    // relasi ke Fonts untuk Title
    public function titleFont()
    {
        return $this->belongsTo(Fonts::class, 'f_title');
    }

    // relasi ke Fonts untuk Sub
    public function subFont()
    {
        return $this->belongsTo(Fonts::class, 'f_sub');
    }
    public function sizeTitle()
    {
        return $this->belongsTo(Fonts::class, 's_title');
    }
}
