<?php

namespace App\Http\Controllers\Pay;

use Midtrans\Config;
use Midtrans\Transaction;
use Midtrans\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction as ModelsTransaction;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // Midtrans Notification
        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        $status = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $transaction = ModelsTransaction::where('invoice', $order_id)->first();
        // dd($transaction->data);
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                $transaction->payment_status = ($fraud == 'challenge') ? 'CHALLENGE' : 'SUCCESS';
            }
        } else if ($status == 'settlement') {
            if ($transaction->data) {
                $transaction->data->isActive = 1;
                $transaction->data->save();
            } else {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Data Id Tidak Ditemukan!'
                    ]
                ]);
            }
            $transaction->payment_status = 'SUCCESS';
        } else if ($status == 'pending') {
            $transaction->payment_status = 'PENDING';
        } else if ($status == 'deny') {
            $transaction->payment_status = 'FAILED';
        } else if ($status == 'expire') {
            $transaction->payment_status = 'EXPIRED';
        } else if ($status == 'cancel') {
            $transaction->payment_status = 'CANCEL';
        }


        $transaction->payment_type = $type;
        $transaction->save();

        // Response json notif postman
        if ($transaction) {
            if ($status == 'capture'  && $fraud == 'deny') {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment Challenge'
                    ]
                ]);
            } else if ($status == 'pending' && $status == 'deny' && $status == 'expire' && $status == 'cancel') {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment Not Settlement'
                    ]
                ]);
            }
        }

        return response()->json([
            'meta' => [
                'code' => 200,
                'message' => 'Midtrans Notification Success'
            ]
        ]);
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
