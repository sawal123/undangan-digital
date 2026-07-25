<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\Controller;
use App\Models\Transaction as ModelsTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        $notif = $this->verifiedNotificationPayload($request);

        if (! $notif) {
            return response()->json(['message' => 'invalid signature'], 403);
        }

        $status = $notif->transaction_status ?? null;
        $type = $notif->payment_type ?? null;
        $order_id = $notif->order_id ?? null;
        $fraud = $notif->fraud_status ?? null;
        $grossAmount = $this->normalizeAmount($notif->gross_amount ?? 0);
        $transactionId = $notif->transaction_id ?? null;

        if (! $order_id) {
            Log::warning('Midtrans callback tanpa order_id', ['payload' => (array) $notif]);

            return response()->json(['message' => 'order_id is required'], 422);
        }

        $response = DB::transaction(function () use ($order_id, $grossAmount, $status, $type, $fraud, $transactionId) {
            $transaction = ModelsTransaction::with('data')->where('invoice', $order_id)->lockForUpdate()->first();

            if (! $transaction) {
                Log::warning('Midtrans callback invoice tidak ditemukan', [
                    'order_id' => $order_id,
                ]);

                return response()->json(['message' => 'transaction not found'], 404);
            }

            if ($grossAmount !== (int) $transaction->gross_amount) {
                Log::warning('Midtrans callback nominal tidak sesuai', [
                    'order_id' => $order_id,
                    'callback_gross_amount' => $grossAmount,
                    'transaction_gross_amount' => (int) $transaction->gross_amount,
                ]);

                return response()->json(['message' => 'gross amount mismatch'], 422);
            }

            $transaction->forceFill([
                'midtrans_payment_type' => $type,
                'midtrans_transaction_id' => $transactionId,
                'midtrans_status' => $status,
                'fraud_status' => $fraud,
            ]);

            match ($status) {
                'settlement' => $this->markSuccess($transaction),
                'capture' => $type === 'credit_card' && $fraud === 'accept'
                    ? $this->markSuccess($transaction)
                    : $this->markChallengeOrPending($transaction, $fraud),
                'pending' => $this->markPending($transaction),
                'deny' => $this->markIfNotSuccess($transaction, 'FAILED'),
                'expire' => $this->markIfNotSuccess($transaction, 'EXPIRED'),
                'cancel' => $this->markIfNotSuccess($transaction, 'CANCEL'),
                'refund', 'partial_refund' => $transaction->payment_status = 'REFUND',
                default => Log::warning('Status Midtrans tidak dikenal', [
                    'invoice' => $transaction->invoice,
                    'status' => $status,
                ]),
            };

            $transaction->save();

            return null;
        });

        if ($response) {
            return $response;
        }

        return response()->json([
            'meta' => [
                'code' => 200,
                'message' => 'Midtrans Notification Success',
            ],
        ]);
    }

    private function verifiedNotificationPayload(Request $request): ?object
    {
        if (! $this->hasValidSignature($request)) {
            Log::warning('Midtrans callback signature tidak valid', [
                'order_id' => $request->input('order_id'),
                'status_code' => $request->input('status_code'),
            ]);

            return null;
        }

        return (object) $request->all();
    }

    private function hasValidSignature(Request $request): bool
    {
        $signature = $request->input('signature_key');
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $serverKey = config('midtrans.serverKey');

        if (! $signature || ! $orderId || ! $statusCode || ! $grossAmount || ! $serverKey) {
            return false;
        }

        $expected = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        return hash_equals($expected, $signature);
    }

    private function normalizeAmount(mixed $amount): int
    {
        return (int) round((float) $amount);
    }

    private function markSuccess(ModelsTransaction $transaction): void
    {
        if ($transaction->payment_status === 'SUCCESS') {
            return;
        }

        $transaction->payment_status = 'SUCCESS';

        if ($transaction->data) {
            $transaction->data->forceFill(['isActive' => true])->save();
        } else {
            Log::warning('Transaksi sukses tanpa relasi undangan', [
                'invoice' => $transaction->invoice,
                'data_id' => $transaction->data_id,
            ]);
        }
    }

    private function markChallengeOrPending(ModelsTransaction $transaction, ?string $fraud): void
    {
        if ($transaction->payment_status === 'SUCCESS') {
            return;
        }

        $transaction->payment_status = $fraud === 'challenge' ? 'CHALLENGE' : 'PENDING';
    }

    private function markPending(ModelsTransaction $transaction): void
    {
        $this->markIfNotSuccess($transaction, 'PENDING');
    }

    private function markIfNotSuccess(ModelsTransaction $transaction, string $status): void
    {
        if ($transaction->payment_status === 'SUCCESS') {
            return;
        }

        $transaction->payment_status = $status;
    }

    public function finishRedirect()
    {
        return view('page.success');
    }

    public function unfinishRedirect(Request $request)
    {
        return view('page.unfinish');
    }

    public function errorRedirect(Request $request)
    {
        return view('page.failed');
    }
}
