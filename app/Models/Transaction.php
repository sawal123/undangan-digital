<?php

namespace App\Models;

use App\Models\Admin\PaySetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_PENDING = 'PENDING';
    public const STATUS_SETTLEMENT = 'SETTLEMENT';
    public const STATUS_SUCCESS = 'SUCCESS';
    public const STATUS_CANCEL = 'CANCEL';
    public const STATUS_FAILED = 'FAILED';
    public const STATUS_EXPIRED = 'EXPIRED';
    public const STATUS_CHALLENGE = 'CHALLENGE';
    public const STATUS_REFUND = 'REFUND';

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
        'payment_method_id',
        'midtrans_payment_type',
        'midtrans_transaction_id',
        'midtrans_status',
        'fraud_status',
    ];

    protected $casts = [
        'price' => 'integer',
        'promo' => 'integer',
        'discount_amount' => 'integer',
        'fee_amount' => 'integer',
        'gross_amount' => 'integer',
    ];

    public static function isSuccessfulStatus(?string $status): bool
    {
        if (!$status) return false;
        $upper = strtoupper(trim($status));
        return in_array($upper, [self::STATUS_SUCCESS, self::STATUS_SETTLEMENT], true);
    }

    public static function isPendingStatus(?string $status): bool
    {
        if (!$status) return false;
        $upper = strtoupper(trim($status));
        return in_array($upper, [self::STATUS_PENDING, self::STATUS_CHALLENGE], true);
    }

    public function scopeSuccessful($query)
    {
        return $query->whereIn(DB::raw('UPPER(payment_status)'), [self::STATUS_SUCCESS, self::STATUS_SETTLEMENT]);
    }

    public function scopePendingStatus($query)
    {
        return $query->whereIn(DB::raw('UPPER(payment_status)'), [self::STATUS_PENDING, self::STATUS_CHALLENGE]);
    }

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
        return $this->belongsTo(PaySetting::class, 'payment_method_id', 'id');
    }
}
