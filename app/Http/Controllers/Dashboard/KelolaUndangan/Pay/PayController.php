<?php

namespace App\Http\Controllers\Dashboard\KelolaUndangan\Pay;

use App\Http\Controllers\Controller;
use App\Models\Data;

class PayController extends Controller
{
    protected function getData($id)
    {
        return Data::where('uid', $id)
            ->where('user_id', auth()->id())
            ->first();
    }

    public function index($id)
    {
        if ($this->getData($id)) {
            return view('user.kelola.pay.pay', [
                'data' => $this->getData($id),
            ]);
        } else {
            return abort('403');
        }

    }

    public function tunai($id)
    {
        if ($this->getData($id)) {
            return view('user.kelola.pay.finishTunai', [
                'data' => $this->getData($id),
            ]);
        } else {
            return abort('403');
        }

    }
}
