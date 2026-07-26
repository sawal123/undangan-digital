<?php

namespace Database\Factories\KelolaUndangan;

use App\Models\Data;
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
            'data_id' => Data::factory(),
            'nama' => $this->faker->name,
            'kode' => $this->faker->unique()->regexify('[a-z0-9]{12}'),
            'nomor' => $this->faker->phoneNumber,
            'slug' => $this->faker->slug,
        ];
    }
}
