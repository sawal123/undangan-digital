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
                'icon' => 'bank-transfer-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'OVO',
                'icon' => 'ovo-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'GoPay',
                'icon' => 'gopay-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'DANA',
                'icon' => 'dana-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'QRIS',
                'icon' => 'qris-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'ShopeePay',
                'icon' => 'shopeepay-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'LinkAja',
                'icon' => 'linkaja-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'BRI',
                'icon' => 'bri-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'BCA',
                'icon' => 'bca-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'BNI',
                'icon' => 'bni-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Mandiri',
                'icon' => 'mandiri-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'CIMB Niaga',
                'icon' => 'cimb-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'BTN',
                'icon' => 'btn-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Permata Bank',
                'icon' => 'permata-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Sinarmas',
                'icon' => 'sinarmas-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Danamon',
                'icon' => 'danamon-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Mega',
                'icon' => 'mega-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Jago',
                'icon' => 'jago-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank BTPN',
                'icon' => 'btpn-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Muamalat',
                'icon' => 'muamalat-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank BJB',
                'icon' => 'bjb-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Bukopin',
                'icon' => 'bukopin-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank BPD',
                'icon' => 'bpd-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank Maybank',
                'icon' => 'maybank-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank HSBC',
                'icon' => 'hsbc-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_pay' => 'Bank OCBC NISP',
                'icon' => 'ocbc-icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
