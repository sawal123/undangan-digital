<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'category' => $this->faker->randomElement(['Pop', 'Rock', 'Jazz', 'Klasik', 'Dangdut', 'Religi', 'Tradisional']),
            'icon' => $this->faker->randomElement(['music', 'guitar', 'drum', 'mic', 'headphones', 'radio']),
        ];
    }
}
