<?php

namespace App\Models\KelolaUndangan;

use App\Models\Data;
use App\Models\GiftPay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kado extends Model
{
    use HasFactory;
    protected $fillable =['data_id', 'gift_id', 'namaPay', 'nomorPay', 'qris'];

    public function data(){
        return $this->belongsTo(Data::class, 'data_id');
    }
    public function giftPay(){
        return $this->belongsTo(GiftPay::class, 'gift_id');
    }

}
