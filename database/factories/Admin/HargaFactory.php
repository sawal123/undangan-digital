<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Harga;
use Illuminate\Database\Eloquent\Factories\Factory;

class HargaFactory extends Factory
{
    protected $model = Harga::class;

    public function definition(): array
    {
        return [
            'harga' => 100000,
            'flashsale' => 0,
        ];
    }
}
