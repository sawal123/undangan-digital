<?php

namespace Database\Seeders;

use App\Models\KelolaUndangan\Tamu;
use App\Models\KelolaUndangan\Ucapan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TamuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tamu::factory()
            ->count(10)
            ->has(Ucapan::factory()->count(1), 'ucapans') // Relasi one-to-one ke ucapan
            ->create();
    }
}
