<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['category' => 'Pop', 'icon' => 'music'],
            ['category' => 'Rock', 'icon' => 'guitar'],
            ['category' => 'Jazz', 'icon' => 'mic'],
            ['category' => 'Klasik', 'icon' => 'headphones'],
            ['category' => 'Dangdut', 'icon' => 'radio'],
            ['category' => 'Religi', 'icon' => 'book-open'],
            ['category' => 'Tradisional', 'icon' => 'disc'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
