<?php

namespace Database\Factories;

use App\Models\Music;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Music>
 */
class MusicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Music::class;

    public function definition()
    {
        return [
            'link' => 'https://www.youtube.com/embed/' . $this->faker->regexify('[A-Za-z0-9]{10}'),
            'judul' => $this->faker->sentence(3),
            'artis' => $this->faker->name,
            'category' => $this->faker->randomElement(['Original', 'Cover', 'Remix']),
        ];
    }
}
