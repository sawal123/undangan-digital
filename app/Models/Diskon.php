<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diskon extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = ['price_id','type', 'diskon'];

    public function priceList(){
        return $this->belongsTo(PriceList::class);
    }
}
