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

        $this->normalizeLegacyTransactionValues();

        $hasInvoiceUnique = $this->hasIndex('transactions', 'transactions_invoice_unique');

        Schema::table('transactions', function (Blueprint $table) use ($hasInvoiceUnique) {
            if (! Schema::hasColumn('transactions', 'discount_amount')) {
                $table->unsignedBigInteger('discount_amount')->default(0)->after('promo');
            }

            if (! Schema::hasColumn('transactions', 'fee_amount')) {
                $table->unsignedBigInteger('fee_amount')->default(0)->after('discount_amount');
            }

            if (! $hasInvoiceUnique) {
                $table->unique('invoice', 'transactions_invoice_unique');
            }
        });

        DB::table('transactions')->orderBy('id')->select(['id', 'promo'])->get()->each(function ($row) {
            DB::table('transactions')->where('id', $row->id)->update([
                'discount_amount' => $this->normalizeAmount($row->promo),
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

    private function normalizeLegacyTransactionValues(): void
    {
        DB::table('transactions')
            ->orderBy('id')
            ->select(['id', 'price', 'promo', 'gross_amount', 'payment_status'])
            ->get()
            ->each(function ($row) {
                DB::table('transactions')->where('id', $row->id)->update([
                    'price' => (string) $this->normalizeAmount($row->price),
                    'promo' => (string) $this->normalizeAmount($row->promo),
                    'gross_amount' => (string) $this->normalizeAmount($row->gross_amount),
                    'payment_status' => $this->normalizePaymentStatus($row->payment_status),
                ]);
            });
    }

    private function normalizeAmount(mixed $value): int
    {
        if ($value === null) {
            return 0;
        }

        $value = trim((string) $value);

        if ($value === '') {
            return 0;
        }

        $value = str($value)
            ->lower()
            ->replace(['rp', 'idr', ' '], '')
            ->toString();

        if (str_starts_with($value, '-')) {
            return 0;
        }

        if (preg_match('/[.,]\d{1,2}$/', $value) === 1) {
            $value = preg_replace('/[.,]\d{1,2}$/', '', $value) ?? $value;
        }

        $digits = preg_replace('/\D+/', '', $value);

        if ($digits === null || $digits === '') {
            return 0;
        }

        return max(0, (int) $digits);
    }

    private function normalizePaymentStatus(mixed $value): string
    {
        $status = strtoupper(trim((string) $value));

        return in_array($status, ['SUCCESS', 'PENDING', 'CANCEL', 'FAILED', 'EXPIRED', 'CHALLENGE', 'REFUND'], true)
            ? $status
            : 'PENDING';
    }

    private function hasIndex(string $table, string $index): bool
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            return DB::selectOne("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$index]) !== null;
        }

        if ($driver === 'sqlite') {
            return collect(DB::select("PRAGMA index_list('{$table}')"))
                ->contains(fn ($row) => ($row->name ?? null) === $index);
        }

        return false;
    }
};
