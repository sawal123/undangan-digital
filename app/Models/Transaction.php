<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'invoice', 
        'data_id', 
        'user_id', 
        'link_snap', 
        'kode',
        'price', 
        'promo', 
        'gross_amount', 
        'payment_status', 
        'payment_type'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function data(){
        return $this->belongsTo(Data::class, 'data_id', 'id');
    }
}
