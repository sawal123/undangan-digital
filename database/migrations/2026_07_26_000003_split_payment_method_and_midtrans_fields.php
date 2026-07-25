<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            ->whereNull('midtrans_code')
            ->orWhere('midtrans_code', '')
            ->orderBy('id')
            ->select(['id', 'category', 'slug'])
            ->get()
            ->each(function ($row) {
                DB::table('pay_settings')->where('id', $row->id)->update([
                    'midtrans_code' => $this->defaultMidtransCode((string) $row->category, (string) $row->slug),
                ]);
            });

        Schema::table('transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('transactions', 'payment_method_id')) {
                $table->foreignId('payment_method_id')
                    ->nullable()
                    ->after('payment_type')
                    ->constrained('pay_settings')
                    ->nullOnDelete();
            }

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

        DB::table('transactions')
            ->whereNull('payment_method_id')
            ->whereNotNull('payment_type')
            ->select(['id', 'payment_type'])
            ->orderBy('id')
            ->get()
            ->each(function ($row) {
                if (ctype_digit((string) $row->payment_type)) {
                    DB::table('transactions')->where('id', $row->id)->update([
                        'payment_method_id' => (int) $row->payment_type,
                    ]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'payment_method_id')) {
                $table->dropConstrainedForeignId('payment_method_id');
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

    private function defaultMidtransCode(string $category, string $slug): string
    {
        return match ($category) {
            'manual' => 'manual',
            'credit_card' => 'credit_card',
            'cstore' => $slug ?: 'cstore',
            'ewallet' => $slug ?: 'gopay',
            'bank_transfer' => str_ends_with($slug, '_va') ? $slug : $slug.'_va',
            default => $slug ?: $category,
        };
    }
};
