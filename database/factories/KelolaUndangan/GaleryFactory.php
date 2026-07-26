<?php

namespace Database\Factories\KelolaUndangan;

use App\Models\Data;
use App\Models\KelolaUndangan\Galery;
use Illuminate\Database\Eloquent\Factories\Factory;

class GaleryFactory extends Factory
{
    protected $model = Galery::class;

    public function definition(): array
    {
        return [
            'data_id' => Data::factory(),
            'sort' => 1,
            'poto' => 'galery/example.jpg',
            'video' => null,
        ];
    }
}
