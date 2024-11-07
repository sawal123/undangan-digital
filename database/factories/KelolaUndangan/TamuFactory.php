<?php

namespace Database\Factories\KelolaUndangan;

use App\Models\KelolaUndangan\Tamu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KelolaUndangan\Tamu>
 */
class TamuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Tamu::class;
    public function definition(): array
    {
        return [
            'data_id' => 1,
            'nama' => $this->faker->name,
            'kode' => $this->faker->unique()->numerify('#####'),
            'nomor' => $this->faker->phoneNumber,
            'slug' => $this->faker->slug,
        ];
    }
}
