<?php

namespace Database\Factories;

use App\Models\Data;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'invoice' => 'INV-'.Str::upper(Str::random(12)),
            'data_id' => Data::factory(),
            'user_id' => User::factory(),
            'link_snap' => '',
            'kode' => '',
            'price' => 100000,
            'promo' => 0,
            'discount_amount' => 0,
            'fee_amount' => 0,
            'gross_amount' => 100000,
            'payment_status' => 'PENDING',
            'payment_type' => null,
        ];
    }
}
