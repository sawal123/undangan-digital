<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\Controller;
use App\Models\Transaction as ModelsTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        $notif = $this->notificationPayload($request);

        $status = $notif->transaction_status ?? null;
        $type = $notif->payment_type ?? null;
        $order_id = $notif->order_id ?? null;
        $fraud = $notif->fraud_status ?? null;
        $grossAmount = (int) ($notif->gross_amount ?? 0);

        if (! $order_id) {
            Log::warning('Midtrans callback tanpa order_id', ['payload' => (array) $notif]);

            return response()->json(['message' => 'order_id is required'], 422);
        }

        $transaction = ModelsTransaction::with('data')->where('invoice', $order_id)->first();

        if (! $transaction) {
            Log::warning('Midtrans callback invoice tidak ditemukan', [
                'order_id' => $order_id,
                'payload' => (array) $notif,
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

        DB::transaction(function () use ($transaction, $status, $type, $fraud) {
            $transaction->refresh();
            $transaction->payment_type = $type;

            match ($status) {
                'settlement' => $this->markSuccess($transaction),
                'capture' => $type === 'credit_card' && $fraud === 'accept'
                    ? $this->markSuccess($transaction)
                    : $this->markChallengeOrPending($transaction, $fraud),
                'pending' => $transaction->payment_status = 'PENDING',
                'deny' => $transaction->payment_status = 'FAILED',
                'expire' => $transaction->payment_status = 'EXPIRED',
                'cancel' => $transaction->payment_status = 'CANCEL',
                'refund', 'partial_refund' => $transaction->payment_status = 'REFUND',
                default => Log::warning('Status Midtrans tidak dikenal', [
                    'invoice' => $transaction->invoice,
                    'status' => $status,
                ]),
            };

            $transaction->save();
        });

        return response()->json([
            'meta' => [
                'code' => 200,
                'message' => 'Midtrans Notification Success',
            ],
        ]);
    }

    private function notificationPayload(Request $request): object
    {
        if ($request->all()) {
            return (object) $request->all();
        }

        try {
            return new Notification;
        } catch (\Exception $e) {
            report($e);

            return (object) [];
        }
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
        $transaction->payment_status = $fraud === 'challenge' ? 'CHALLENGE' : 'PENDING';
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
