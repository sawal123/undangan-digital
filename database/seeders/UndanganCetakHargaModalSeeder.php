<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UndanganCetakHargaModalSeeder extends Seeder
{
    /**
     * Memetakan harga modal dan ukuran plastik OPP berdasarkan:
     * - DAFTAR HARGA 1.pdf
     * - DAFTAR HARGA 2.pdf
     *
     * Seeder ini hanya mengubah kolom harga_modal dan ukuran_opp.
     * Kolom gambar/thumbnail dan data produk lainnya tidak disentuh.
     */
    public function run(): void
    {
        $priceMap = $this->priceMap();
        $updated = 0;
        $unmatched = [];

        DB::transaction(function () use ($priceMap, &$updated, &$unmatched): void {
            $products = DB::table('undangan_cetaks')
                ->select(['id', 'nama'])
                ->orderBy('id')
                ->get();

            foreach ($products as $product) {
                $key = $this->normalizeName($product->nama);

                if (! isset($priceMap[$key])) {
                    $unmatched[] = $product->nama;

                    continue;
                }

                DB::table('undangan_cetaks')
                    ->where('id', $product->id)
                    ->update([
                        'harga_modal' => $priceMap[$key]['harga_modal'],
                        'ukuran_opp' => $priceMap[$key]['ukuran_opp'],
                    ]);

                $updated++;
            }
        });

        $this->command?->info("Berhasil memperbarui {$updated} data undangan cetak.");

        if ($unmatched !== []) {
            $this->command?->warn(
                'Tidak ditemukan pada dua daftar harga: '.implode(', ', $unmatched)
            );
        }
    }

    /**
     * @return array<string, array{harga_modal: int, ukuran_opp: string}>
     */
    private function priceMap(): array
    {
        $map = [];

        $addRange = function (
            string $prefix,
            int $from,
            int $to,
            string $ukuranOpp,
            int $hargaModal,
            bool $padTwoDigits = false
        ) use (&$map): void {
            for ($number = $from; $number <= $to; $number++) {
                $code = $padTwoDigits
                    ? str_pad((string) $number, 2, '0', STR_PAD_LEFT)
                    : (string) $number;

                $map[$this->normalizeName("{$prefix} {$code}")] = [
                    'harga_modal' => $hargaModal,
                    'ukuran_opp' => $ukuranOpp,
                ];
            }
        };

        // DAFTAR HARGA 1 - Maliq
        $addRange('Maliq', 4, 6, '12 x 22', 550, true);
        $addRange('Maliq', 8, 8, '11,5 x 22', 550, true);
        $addRange('Maliq', 11, 11, '11,5 x 22', 500);
        $addRange('Maliq', 13, 25, '13 x 22', 550);
        $addRange('Maliq', 26, 27, '13,5 x 22', 550);
        $addRange('Maliq', 28, 30, '13,5 x 22', 600);
        $addRange('Maliq', 31, 32, '15,5 x 22', 600);
        $addRange('Maliq', 33, 35, '13,5 x 22', 600);
        $addRange('Maliq', 36, 37, '15,5 x 22', 600);
        $addRange('Maliq', 38, 40, '13,5 x 22', 600);
        $addRange('Maliq', 41, 42, '11,5 x 22', 500);
        $addRange('Maliq', 43, 48, '13 x 22', 550);
        $addRange('Maliq', 49, 51, '13,5 x 22', 500);
        $addRange('Maliq', 52, 53, '13,5 x 22', 550);
        $addRange('Maliq', 54, 54, '15 x 22', 600);
        $addRange('Maliq', 55, 56, '13,5 x 22', 600);
        $addRange('Maliq', 57, 60, '11,5 x 22', 450);
        $addRange('Maliq', 61, 64, '13,5 x 22', 500);
        $addRange('Maliq', 65, 68, '11,5 x 22', 500);
        $addRange('Maliq', 69, 72, '13,5 x 22', 550);
        $addRange('Maliq', 73, 74, '13,5 x 22', 700);
        $addRange('Maliq', 75, 77, '13,5 x 22', 500);
        $addRange('Maliq', 78, 79, '13,5 x 22', 600);
        $addRange('Maliq', 80, 82, '15 x 22', 700);
        $addRange('Maliq', 83, 84, '13,5 x 22', 600);
        $addRange('Maliq', 85, 87, '15 x 22', 650);
        $addRange('Maliq', 88, 89, '13,5 x 22', 550);
        $addRange('Maliq', 90, 94, '15 x 22', 600);
        $addRange('Maliq', 95, 98, '11,5 x 22', 500);
        $addRange('Maliq', 99, 99, '14 x 22', 700);
        $addRange('Maliq', 100, 100, '15,5 x 22', 700);
        $addRange('Maliq', 101, 105, '12 x 22', 500);
        $addRange('Maliq', 106, 107, '15,5 x 22', 700);
        $addRange('Maliq', 108, 109, '14 x 22', 500);
        $addRange('Maliq', 110, 112, '14,5 x 22', 650);

        // DAFTAR HARGA 1 - Indie
        $addRange('Indie', 81, 86, '12 x 22', 500);

        // DAFTAR HARGA 1 - Be You (nama produk di database: Java Be You)
        $addRange('Java Be You', 1, 1, '14,5 x 22', 550, true);
        $addRange('Java Be You', 2, 3, '17 x 22', 550, true);
        $addRange('Java Be You', 4, 4, '14,5 x 22', 550, true);
        $addRange('Java Be You', 5, 5, '12 x 22', 550, true);
        $addRange('Java Be You', 6, 6, '14,5 x 22', 550, true);

        // DAFTAR HARGA 1 - Infinity
        $addRange('Infinity Design', 1, 1, '15,5 x 22', 700, true);
        $addRange('Infinity Design', 2, 2, '15,5 x 22', 900, true);
        $addRange('Infinity Design', 3, 5, '15,5 x 22', 700, true);
        $addRange('Infinity Design', 6, 7, '14 x 22', 1100, true);
        $addRange('Infinity Design', 8, 9, '13,5 x 22', 1400, true);
        $addRange('Infinity Design', 10, 10, '13,5 x 22', 1500);
        $addRange('Infinity Design', 11, 12, '12,5 x 22', 3000);
        $addRange('Infinity Design', 14, 15, '15,5 x 22', 900);
        $addRange('Infinity Design', 16, 17, '15,5 x 22', 950);
        $addRange('Infinity Design', 18, 21, '13 x 22', 1100);
        $addRange('Infinity Design', 23, 25, '13,5 x 22', 2000);
        $addRange('Infinity Design', 26, 26, '11 x 22', 1300);
        $addRange('Infinity Design', 27, 28, '11 x 22', 1250);
        $addRange('Infinity Design', 29, 30, '13,5 x 22', 2000);
        $addRange('Infinity Design', 31, 32, '13,5 x 22', 1100);
        $addRange('Infinity Design', 33, 33, '15,5 x 22', 900);
        $addRange('Infinity Design', 34, 34, '15,5 x 22', 700);
        $addRange('Infinity Design', 35, 35, '15,5 x 22', 1150);
        $addRange('Infinity Design', 41, 41, '13,5 x 22', 2000);

        // DAFTAR HARGA 1 - Zigna
        $addRange('Zigna', 1, 2, '15,5 x 22', 600, true);
        $addRange('Zigna', 3, 4, '13 x 22', 750, true);
        $addRange('Zigna', 5, 5, '14 x 22', 850, true);
        $addRange('Zigna', 6, 6, '13,5 x 22', 900, true);
        $addRange('Zigna', 7, 7, '12,5 x 22', 850, true);
        $addRange('Zigna', 8, 9, '16 x 22', 850, true);
        $addRange('Zigna', 10, 12, '14,5 x 22', 1900);

        // DAFTAR HARGA 1 - Inovasi Card
        $addRange('IC', 1, 3, '12,5 x 22', 1100, true);
        $addRange('IC', 4, 4, '13 x 22', 1100, true);
        $addRange('IC', 5, 5, '12 x 22', 1100, true);
        $addRange('IC', 6, 6, '12,5 x 22', 1100, true);
        $addRange('IC', 7, 12, '11 x 22', 750, true);
        $addRange('IC', 13, 15, '14,5 x 22', 1000);
        $addRange('IC', 16, 16, '13,5 x 22', 1100);
        $addRange('IC', 17, 19, '10,5 x 22', 1100);
        $addRange('IC', 20, 25, '12 x 22', 1100);
        $addRange('IC', 26, 29, '14,5 x 22', 1000);
        $addRange('IC', 30, 32, '13 x 22', 1100);
        $addRange('IC', 33, 35, '12,5 x 22', 800);
        $addRange('IC', 36, 37, '14 x 22', 800);
        $addRange('IC', 38, 38, '14,5 x 22', 800);
        $addRange('IC', 39, 39, '15,5 x 22', 800);
        $addRange('IC', 40, 41, '12 x 22', 700);
        $addRange('IC', 42, 42, '12,5 x 22', 700);
        $addRange('IC', 43, 44, '13 x 22', 700);
        $addRange('IC', 45, 45, '12 x 22', 700);
        $addRange('IC', 46, 48, '13 x 22', 700);
        $addRange('IC', 49, 51, '12 x 22', 700);

        // DAFTAR HARGA 1 - Raffa
        $addRange('Raffa', 54, 55, '14 x 22', 600);
        $addRange('Raffa', 56, 56, '15 x 22', 600);
        $addRange('Raffa', 57, 57, '13,5 x 22', 600);
        $addRange('Raffa', 58, 58, '15 x 22', 600);
        $addRange('Raffa', 59, 59, '14,5 x 22', 600);
        $addRange('Raffa', 60, 60, '15 x 22', 600);
        $addRange('Raffa', 61, 63, '16,5 x 22', 600);
        $addRange('Raffa', 64, 65, '13,5 x 22', 600);
        $addRange('Raffa', 66, 69, '11,5 x 22', 450);
        $addRange('Raffa', 70, 70, '15,5 x 22', 600);
        $addRange('Raffa', 71, 78, '15 x 22', 700);
        $addRange('Raffa', 79, 79, '13,5 x 22', 700);
        $addRange('Raffa', 80, 80, '14 x 22', 700);
        $addRange('Raffa', 81, 81, '15,5 x 22', 700);
        $addRange('Raffa', 82, 85, '15 x 22', 700);
        $addRange('Raffa', 86, 90, '15,5 x 22', 1450);
        $addRange('Raffa', 91, 93, '15,5 x 22', 700);
        $addRange('Raffa', 94, 94, '15 x 22', 700);
        $addRange('Raffa', 95, 97, '15,5 x 22', 700);
        $addRange('Raffa', 98, 98, '14 x 22', 700);
        $addRange('Raffa', 99, 100, '15,5 x 22', 700);
        $addRange('Raffa', 101, 102, '14,5 x 22', 700);
        $addRange('Raffa', 103, 104, '13,5 x 22', 700);
        $addRange('Raffa', 105, 105, '16 x 22', 3000);
        $addRange('Raffa', 106, 106, '14 x 22', 3000);

        // DAFTAR HARGA 2 - Jago
        $addRange('Jago', 1, 14, '11,5 x 22', 450, true);
        $addRange('Jago', 15, 24, '13 x 22', 600);
        $addRange('Jago', 25, 28, '11,5 x 22', 450);
        $addRange('Jago', 29, 34, '13 x 22', 600);
        $addRange('Jago', 35, 40, '14,5 x 22', 950);
        $addRange('Jago', 41, 45, '11,5 x 22', 450);
        $addRange('Jago', 46, 50, '10,5 x 22', 450);
        $addRange('Jago', 51, 55, '13,5 x 22', 550);
        $addRange('Jago', 56, 59, '13,5 x 22', 600);
        $addRange('Jago', 60, 61, '12,5 x 22', 600);
        $addRange('Jago', 62, 64, '13,5 x 22', 600);
        $addRange('Jago', 65, 65, '13,5 x 22', 550);
        $addRange('Jago', 66, 66, '13,5 x 22', 650);
        $addRange('Jago', 67, 67, '14 x 22', 550);
        $addRange('Jago', 68, 68, '14 x 22', 650);
        $addRange('Jago', 69, 70, '13,5 x 22', 650);
        $addRange('Jago', 71, 71, '14 x 22', 650);
        $addRange('Jago', 72, 72, '12 x 22', 550);
        $addRange('Jago', 73, 74, '12,5 x 22', 650);

        // DAFTAR HARGA 2 - HC
        foreach ([105, 109] as $number) {
            $map[$this->normalizeName("HC {$number}")] = [
                'harga_modal' => 850,
                'ukuran_opp' => '15 x 25',
            ];
        }

        $addRange('HC', 110, 110, '14,5 x 25', 850);
        $addRange('HC', 123, 124, '15 x 25', 850);
        $addRange('HC', 125, 130, '16 x 22', 500);
        $addRange('HC', 131, 133, '13,5 x 22', 500);
        $addRange('HC', 134, 134, '16 x 22', 500);
        $addRange('HC', 135, 135, '15,5 x 22', 500);
        $addRange('HC', 136, 136, '16 x 22', 500);
        $addRange('HC', 137, 138, '14 x 22', 500);
        $addRange('HC', 139, 140, '15,5 x 22', 500);
        $addRange('HC', 141, 142, '13 x 22', 500);
        $addRange('HC', 143, 145, '16 x 22', 500);
        $addRange('HC', 146, 148, '14,5 x 22', 500);
        $addRange('HC', 149, 150, '13,5 x 22', 500);
        $addRange('HC', 172, 172, '13,5 x 22', 500);
        $addRange('HC', 174, 174, '14 x 22', 600);
        $addRange('HC', 175, 175, '12 x 22', 500);
        $addRange('HC', 179, 180, '13,5 x 22', 550);
        $addRange('HC', 181, 184, '15 x 22', 600);
        $addRange('HC', 185, 186, '14 x 22', 500);
        $addRange('HC', 187, 189, '11 x 22', 500);
        $addRange('HC', 190, 192, '14 x 22', 500);
        $addRange('HC', 193, 195, '11 x 22', 500);
        $addRange('HC', 196, 198, '12 x 22', 500);
        $addRange('HC', 199, 200, '14 x 22', 400);
        $addRange('HC', 201, 202, '14 x 22', 500);
        $addRange('HC', 203, 204, '14,5 x 22', 600);
        $addRange('HC', 205, 205, '14,5 x 22', 550);

        // DAFTAR HARGA 2 - Lintang
        $addRange('Lintang', 59, 60, '16,5 x 22', 600);
        $addRange('Lintang', 61, 62, '13,5 x 22', 600);
        $addRange('Lintang', 63, 66, '13,5 x 22', 700);
        $addRange('Lintang', 67, 69, '13,5 x 22', 700);
        $addRange('Lintang', 70, 73, '13,5 x 22', 600);
        $addRange('Lintang', 74, 78, '13,5 x 22', 600);
        $addRange('Lintang', 79, 80, '15,5 x 22', 500);
        $addRange('Lintang', 81, 83, '12,5 x 22', 500);
        $addRange('Lintang', 84, 88, '13,5 x 22', 600);
        $addRange('Lintang', 89, 93, '13,5 x 22', 550);

        return $map;
    }

    private function normalizeName(string $name): string
    {
        $normalized = preg_replace('/\s+/', ' ', trim($name));

        return strtolower($normalized ?? trim($name));
    }
}
