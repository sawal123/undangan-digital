<?php

namespace Database\Seeders;

use App\Models\Fonts;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FontsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fonts = [
            [
                'nama' => 'Oleo Script Swash Caps',
                'link' => 'https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps:wght@400;700&display=swap',
                'is_active' => true,
            ],
            [
                'nama' => 'Capriola',
                'link' => 'https://fonts.googleapis.com/css2?family=Capriola&display=swap',
                'is_active' => true,
            ],
            [
                'nama' => 'Great Vibes',
                'link' => 'https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap',
                'is_active' => true,
            ],
            [
                'nama' => 'Dancing Script',
                'link' => 'https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap',
                'is_active' => true,
            ],
            [
                'nama' => 'Parisienne',
                'link' => 'https://fonts.googleapis.com/css2?family=Parisienne&display=swap',
                'is_active' => true,
            ],
            [
                'nama' => 'Sacramento',
                'link' => 'https://fonts.googleapis.com/css2?family=Sacramento&display=swap',
                'is_active' => true,
            ],
            [
                'nama' => 'Alex Brush',
                'link' => 'https://fonts.googleapis.com/css2?family=Alex+Brush&display=swap',
                'is_active' => true,
            ],
            [
                'nama' => 'Playfair Display',
                'link' => 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap',
                'is_active' => true,
            ],
            [
                'nama' => 'Merriweather',
                'link' => 'https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap',
                'is_active' => true,
            ],
            [
                'nama' => 'Poppins',
                'link' => 'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap',
                'is_active' => true,
            ],
        ];

        foreach ($fonts as $font) {
            Fonts::create($font);
        }
    }
}
