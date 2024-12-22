<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GiftPaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gift_pays')->insert([
            [
                'nama_pay' => 'Bank Transfer',
                'icon' => 'gift/bank-transfer.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Mestika Dharma',
                'icon' => 'gift/Bank Mestika Dharma.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'OVO',
                'icon' => 'gift/ovo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'GoPay',
                'icon' => 'gift/gopay.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'DANA',
                'icon' => 'gift/dana.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'QRIS',
                'icon' => 'gift/qris.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'ShopeePay',
                'icon' => 'gift/shoope-pay.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'LinkAja',
                'icon' => 'gift/link aja.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'BRI',
                'icon' => 'gift/BRI.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'BCA',
                'icon' => 'gift/bca.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'BNI',
                'icon' => 'gift/bni.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Mandiri',
                'icon' => 'gift/mandiri.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'CIMB Niaga',
                'icon' => 'gift/cimb_niaga.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'BTN',
                'icon' => 'gift/btn.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Permata Bank',
                'icon' => 'gift/permata Bank.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Sinarmas',
                'icon' => 'gift/sinarmas.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Danamon',
                'icon' => 'gift/danamon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Mega',
                'icon' => 'gift/bank mega.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Jago',
                'icon' => 'gift/bank jago.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank BTPN',
                'icon' => 'gift/btpn.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Muamalat',
                'icon' => 'gift/muamalat.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank BJB',
                'icon' => 'gift/bjb.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Bukopin',
                'icon' => 'gift/bukopin.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank BPD',
                'icon' => 'gift/bpd.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Maybank',
                'icon' => 'gift/maybank.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank HSBC',
                'icon' => 'gift/hsbc.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank OCBC NISP',
                'icon' => 'gift/ocbc.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
