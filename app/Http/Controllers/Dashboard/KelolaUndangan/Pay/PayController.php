<?php

namespace App\Http\Controllers\Dashboard\KelolaUndangan\Pay;

use App\Http\Controllers\Controller;
use App\Models\Data;

class PayController extends Controller
{
    protected function getData(string $id): ?Data
    {
        if (empty($id)) {
            return null;
        }

        return Data::where('uid', $id)
            ->where('user_id', auth()->id())
            ->first();
    }

    public function index(string $id): \Illuminate\View\View
    {
        $data = $this->getData($id);
        if (!$data) {
            abort(403);
        }
        return view('user.kelola.pay.pay', [
            'data' => $data,
        ]);
    }

    public function tunai(string $id): \Illuminate\View\View
    {
        $data = $this->getData($id);
        if (!$data) {
            abort(403);
        }
        return view('user.kelola.pay.finishTunai', [
            'data' => $data,
        ]);
    }
}
