<?php

namespace Database\Factories\Admin;

use App\Models\Admin\Promo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromoFactory extends Factory
{
    protected $model = Promo::class;

    public function definition(): array
    {
        return [
            'kode' => fake()->unique()->bothify('PROMO##'),
            'promo' => '10000',
            'type' => 'fixed',
            'isActive' => true,
        ];
    }
}
