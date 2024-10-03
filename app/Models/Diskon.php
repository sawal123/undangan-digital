<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diskon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type', 'diskon'];

    public function priceList(){
        return $this->hasMany(PriceList::class);
    }
}
