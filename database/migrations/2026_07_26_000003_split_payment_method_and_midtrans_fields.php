<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pay_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('pay_settings', 'midtrans_code')) {
                $table->string('midtrans_code')->nullable()->after('slug');
            }
        });

        DB::table('pay_settings')
            ->orderBy('id')
            ->select(['id', 'category', 'slug', 'midtrans_code', 'isActive'])
            ->get()
            ->each(function ($row) {
                $category = $this->canonicalCategory((string) $row->category);

                if (! $category) {
                    Log::warning('Kategori pembayaran legacy perlu diperiksa manual', [
                        'pay_setting_id' => $row->id,
                        'category' => $row->category,
                        'slug' => $row->slug,
                    ]);

                    DB::table('pay_settings')->where('id', $row->id)->update([
                        'isActive' => false,
                        'midtrans_code' => null,
                    ]);

                    return;
                }

                DB::table('pay_settings')->where('id', $row->id)->update([
                    'category' => $category,
                    'midtrans_code' => $this->isValidMidtransCode($category, (string) $row->midtrans_code)
                        ? str($row->midtrans_code)->lower()->replace('-', '_')->toString()
                        : $this->defaultMidtransCode($category, (string) $row->slug),
                ]);
            });

        $createdPaymentMethodColumn = ! Schema::hasColumn('transactions', 'payment_method_id');

        Schema::table('transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('transactions', 'payment_method_id')) {
                $table->foreignId('payment_method_id')
                    ->nullable()
                    ->after('payment_type');
            }
        });

        $paymentSettingIds = DB::table('pay_settings')->pluck('id')->map(fn ($id) => (int) $id)->all();

        DB::table('transactions')
            ->whereNull('payment_method_id')
            ->whereNotNull('payment_type')
            ->select(['id', 'payment_type'])
            ->orderBy('id')
            ->get()
            ->each(function ($row) use ($paymentSettingIds) {
                $paymentType = (string) $row->payment_type;

                if (ctype_digit($paymentType) && in_array((int) $paymentType, $paymentSettingIds, true)) {
                    DB::table('transactions')->where('id', $row->id)->update([
                        'payment_method_id' => (int) $paymentType,
                    ]);
                }
            });

        if ($createdPaymentMethodColumn) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->foreign('payment_method_id')
                    ->references('id')
                    ->on('pay_settings')
                    ->nullOnDelete();
            });
        }

        Schema::table('transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('transactions', 'midtrans_payment_type')) {
                $table->string('midtrans_payment_type')->nullable()->after('payment_method_id');
            }

            if (! Schema::hasColumn('transactions', 'midtrans_transaction_id')) {
                $table->string('midtrans_transaction_id')->nullable()->after('midtrans_payment_type');
            }

            if (! Schema::hasColumn('transactions', 'midtrans_status')) {
                $table->string('midtrans_status')->nullable()->after('midtrans_transaction_id');
            }

            if (! Schema::hasColumn('transactions', 'fraud_status')) {
                $table->string('fraud_status')->nullable()->after('midtrans_status');
            }
        });
    }

    public function down(): void
    {
        try {
            Schema::table('transactions', function (Blueprint $table) {
                if (Schema::hasColumn('transactions', 'payment_method_id')) {
                    $table->dropForeign(['payment_method_id']);
                }
            });
        } catch (Throwable) {
        }

        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'payment_method_id')) {
                $table->dropColumn('payment_method_id');
            }

            foreach (['midtrans_payment_type', 'midtrans_transaction_id', 'midtrans_status', 'fraud_status'] as $column) {
                if (Schema::hasColumn('transactions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('pay_settings', function (Blueprint $table) {
            if (Schema::hasColumn('pay_settings', 'midtrans_code')) {
                $table->dropColumn('midtrans_code');
            }
        });
    }

    private function canonicalCategory(string $category): ?string
    {
        $normalized = str($category)
            ->lower()
            ->replace([' ', '-'], '_')
            ->replace('__', '_')
            ->toString();

        return match ($normalized) {
            'manual', 'cash' => 'manual',
            'bank_transfer', 'va' => 'bank_transfer',
            'e_wallet', 'ewallet' => 'ewallet',
            'credit_card' => 'credit_card',
            'cstore' => 'cstore',
            default => null,
        };
    }

    private function defaultMidtransCode(string $category, string $slug): string
    {
        $slug = str($slug)->lower()->replace('-', '_')->toString();

        return match ($category) {
            'manual' => 'manual',
            'credit_card' => 'credit_card',
            'cstore' => in_array($slug, ['alfamart', 'indomaret'], true) ? $slug : 'cstore',
            'ewallet' => in_array($slug, ['gopay', 'shopeepay', 'qris'], true) ? $slug : 'gopay',
            'bank_transfer' => in_array($slug, ['bank_transfer', 'bca_va', 'bni_va', 'bri_va', 'permata_va', 'echannel'], true)
                ? $slug
                : 'bank_transfer',
            default => $category,
        };
    }

    private function isValidMidtransCode(string $category, string $midtransCode): bool
    {
        $midtransCode = str($midtransCode)->lower()->replace('-', '_')->toString();

        return match ($category) {
            'manual' => $midtransCode === 'manual',
            'credit_card' => $midtransCode === 'credit_card',
            'cstore' => in_array($midtransCode, ['cstore', 'alfamart', 'indomaret'], true),
            'ewallet' => in_array($midtransCode, ['gopay', 'shopeepay', 'qris'], true),
            'bank_transfer' => in_array($midtransCode, ['bank_transfer', 'bca_va', 'bni_va', 'bri_va', 'permata_va', 'echannel'], true),
            default => false,
        };
    }
};
