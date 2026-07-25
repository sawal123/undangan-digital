<?php

namespace App\Models;

use App\Models\Admin\PaySetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'discount_amount',
        'fee_amount',
        'gross_amount',
        'payment_status',
        'payment_type',
    ];

    protected $casts = [
        'price' => 'integer',
        'promo' => 'integer',
        'discount_amount' => 'integer',
        'fee_amount' => 'integer',
        'gross_amount' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function data()
    {
        return $this->belongsTo(Data::class, 'data_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(PaySetting::class, 'payment_type', 'id');
    }
}
