<?php

namespace Database\Factories\Admin;

use App\Models\Admin\PaySetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaySettingFactory extends Factory
{
    protected $model = PaySetting::class;

    public function definition(): array
    {
        return [
            'bank' => 'Manual',
            'category' => 'manual',
            'fee' => '0',
            'image' => 'payment/manual.png',
            'deskripsi' => null,
            'isActive' => true,
            'slug' => 'manual',
            'midtrans_code' => 'manual',
        ];
    }
}
