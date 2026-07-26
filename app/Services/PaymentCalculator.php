<?php

namespace App\Services;

use App\Models\Admin\Harga;
use App\Models\Admin\PaySetting;
use App\Models\Admin\Promo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class PaymentCalculator
{
    public function calculate(?string $promoCode, PaySetting $paymentMethod): array
    {
        $price = Harga::query()->latest('id')->first();

        if (! $price) {
            throw ValidationException::withMessages(['payment' => 'Harga aktif tidak tersedia.']);
        }

        $basePrice = (int) $price->harga;
        $discountAmount = 0;
        $promo = null;

        if ($promoCode) {
            $promo = Promo::query()
                ->where('kode', $promoCode)
                ->when(Schema::hasColumn('promos', 'isActive'), fn ($query) => $query->where('isActive', true))
                ->first();

            if (! $promo) {
                throw ValidationException::withMessages(['code' => 'Kode promo tidak berlaku.']);
            }

            if (Schema::hasColumn('promos', 'expired_at') && $promo->expired_at && now()->greaterThan($promo->expired_at)) {
                throw ValidationException::withMessages(['code' => 'Kode promo sudah kedaluwarsa.']);
            }

            if (Schema::hasColumn('promos', 'minimum_transaction') && (int) $promo->minimum_transaction > $basePrice) {
                throw ValidationException::withMessages(['code' => 'Minimum transaksi promo belum terpenuhi.']);
            }

            if (Schema::hasColumn('promos', 'usage_limit') && $promo->usage_limit !== null && (int) $promo->usage_limit <= 0) {
                throw ValidationException::withMessages(['code' => 'Batas pemakaian promo sudah habis.']);
            }

            $discountAmount = min((int) $promo->promo, $basePrice);
        }

        $subtotal = max(0, $basePrice - $discountAmount);
        $feeAmount = $paymentMethod->category === 'ewallet'
            ? (int) ceil($subtotal * ((float) $paymentMethod->fee / 100))
            : (int) $paymentMethod->fee;

        $grossAmount = $subtotal + max(0, $feeAmount);

        if ($grossAmount <= 0) {
            throw ValidationException::withMessages(['payment' => 'Total pembayaran tidak valid.']);
        }

        return [
            'base_price' => $basePrice,
            'discount_amount' => $discountAmount,
            'fee_amount' => max(0, $feeAmount),
            'gross_amount' => $grossAmount,
            'promo' => $promo,
        ];
    }
}
