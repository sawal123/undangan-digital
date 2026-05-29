<?php

namespace Database\Seeders;

use App\Models\EventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eventTypes = [
            [
                'name' => 'Pernikahan',
                'key' => 'wedding',
                'description' => 'Undangan akad, resepsi, dan rangkaian acara pernikahan.',
            ],
            [
                'name' => 'Ulang Tahun',
                'key' => 'birthday',
                'description' => 'Undangan ulang tahun anak, dewasa, atau sweet seventeen.',
            ],
            [
                'name' => 'Tunangan',
                'key' => 'engagement',
                'description' => 'Undangan lamaran atau pertunangan.',
            ],
            [
                'name' => 'Pengajian',
                'key' => 'pengajian',
                'description' => 'Undangan pengajian, tasyakuran, atau kajian.',
            ],
            [
                'name' => 'Event',
                'key' => 'event',
                'description' => 'Undangan seminar, gathering, launching, dan event umum.',
            ],
        ];

        foreach ($eventTypes as $eventType) {
            EventType::updateOrCreate(
                ['key' => $eventType['key']],
                $eventType
            );
        }
    }
}
