<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('transactions')
            ->whereNull('invoice')
            ->orWhere('invoice', '')
            ->orderBy('id')
            ->select('id')
            ->get()
            ->each(function ($row) {
                DB::table('transactions')->where('id', $row->id)->update([
                    'invoice' => $this->invoice(),
                ]);
            });

        $seen = [];
        DB::table('transactions')
            ->orderBy('id')
            ->select(['id', 'invoice'])
            ->get()
            ->each(function ($row) use (&$seen) {
                if (! isset($seen[$row->invoice])) {
                    $seen[$row->invoice] = true;

                    return;
                }

                DB::table('transactions')->where('id', $row->id)->update([
                    'invoice' => $this->invoice(),
                ]);
            });

        Schema::table('transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('transactions', 'discount_amount')) {
                $table->unsignedBigInteger('discount_amount')->default(0)->after('promo');
            }

            if (! Schema::hasColumn('transactions', 'fee_amount')) {
                $table->unsignedBigInteger('fee_amount')->default(0)->after('discount_amount');
            }

            $table->unique('invoice', 'transactions_invoice_unique');
        });

        DB::table('transactions')->orderBy('id')->select(['id', 'promo'])->get()->each(function ($row) {
            DB::table('transactions')->where('id', $row->id)->update([
                'discount_amount' => (int) $row->promo,
            ]);
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE transactions MODIFY invoice VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE transactions MODIFY price BIGINT UNSIGNED NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE transactions MODIFY promo BIGINT UNSIGNED NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE transactions MODIFY gross_amount BIGINT UNSIGNED NOT NULL DEFAULT 0');
            DB::statement("ALTER TABLE transactions MODIFY payment_status ENUM('SUCCESS','PENDING','CANCEL','FAILED','EXPIRED','CHALLENGE','REFUND') NOT NULL DEFAULT 'PENDING'");
        }
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropUnique('transactions_invoice_unique');
            $table->dropColumn(['discount_amount', 'fee_amount']);
        });

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE transactions MODIFY payment_status ENUM('SUCCESS','PENDING','CANCEL','FAILED','EXPIRED') NOT NULL");
        }
    }

    private function invoice(): string
    {
        do {
            $invoice = 'INV-'.Str::upper(Str::random(12));
        } while (DB::table('transactions')->where('invoice', $invoice)->exists());

        return $invoice;
    }
};
