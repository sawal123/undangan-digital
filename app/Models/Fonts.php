<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonts extends Model
{
    use HasFactory;
    protected $table = 'fonts';
    protected $fillable = ['nama', 'link', 'is_active'];

    // font bisa dipakai sebagai title di banyak dataFonts
    public function asTitleInDataFonts()
    {
        return $this->hasMany(DataFonts::class, 'f_title');
    }

    // font bisa dipakai sebagai sub di banyak dataFonts
    public function asSubInDataFonts()
    {
        return $this->hasMany(DataFonts::class, 'f_sub');
    }


}
