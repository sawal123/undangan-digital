<?php

namespace Database\Factories\KelolaUndangan;

use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\Ucapan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UcapanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Ucapan::class;

    public function definition()
    {
        return [
            'data_id' => 1, // Sesuaikan sesuai kebutuhan
            'ucapan' => $this->faker->sentence,
            'balas' => null,
            'status' => 'Hadir',
        ];
    }
}
