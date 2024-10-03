<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeskripsiPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['deskripsi'];
    public function priceList(){
        return $this->hasMany(PriceList::class);
    }
}
