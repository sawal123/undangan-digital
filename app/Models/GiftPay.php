<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftPay extends Model
{
    use HasFactory;
    protected $fillable = ['nama_pay', 'icon'];

    public function kado(){
        return $this->hasMany(GiftPay::class);
    }
}
