<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Studio;
use App\Models\Seat;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        $studios = Studio::all();

        // Konfigurasi kursi: baris A-F, nomor 1-16
        $baris   = ['A', 'B', 'C', 'D', 'E', 'F'];
        $jumlahPerBaris = 16;

        foreach ($studios as $studio) {
            foreach ($baris as $b) {
                for ($n = 1; $n <= $jumlahPerBaris; $n++) {
                    Seat::create([
                        'studio_id'   => $studio->id,
                        'nomor_kursi' => $b . $n,
                        'baris'       => $b,
                        'nomor'       => $n,
                    ]);
                }
            }
        }

        $totalKursi = $studios->count() * count($baris) * $jumlahPerBaris;
        $this->command->info('✅ Seat seeder selesai: ' . $totalKursi . ' kursi ditambahkan.');
    }
}