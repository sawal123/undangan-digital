<?php

namespace Database\Seeders;

use App\Models\Music as ModelsMusic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Music extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsMusic::factory()->count(10)->create();
    }
}
