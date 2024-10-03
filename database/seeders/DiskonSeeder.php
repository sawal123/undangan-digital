<?php

namespace Database\Seeders;

use App\Models\Diskon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiskonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diskon = Diskon::insert([
            [
                'type'=> 'rupiah',
                'diskon'=> '10000'
            ],
            [
                'type'=> 'persen',
                'diskon'=> '20'
            ],
            [
                'type'=> 'rupiah',
                'diskon'=> '20000'
            ],
            [
                'type'=> 'persen',
                'diskon'=> '30'
            ],
            
        ]);
    }
}
