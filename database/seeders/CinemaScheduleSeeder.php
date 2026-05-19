<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\Studio;
use App\Models\Schedule;
use Carbon\Carbon;

class CinemaScheduleSeeder extends Seeder
{
    public function run(): void
    {


        $cinemaNames = [
            'CENTRAL LAMPUNG XXI',
            'MALL BOEMI KEDATON XXI',
            'CIPLAZ LAMPUNG XXI',
        ];

        $cinemas = Studio::whereIn('nama', $cinemaNames)
            ->orderByRaw("
                CASE
                    WHEN nama = 'CENTRAL LAMPUNG XXI' THEN 1
                    WHEN nama = 'MALL BOEMI KEDATON XXI' THEN 2
                    WHEN nama = 'CIPLAZ LAMPUNG XXI' THEN 3
                    ELSE 4
                END
            ")
            ->get();

        if ($cinemas->isEmpty()) {
            $this->command->warn('Tidak ada data bioskop Lampung. Jalankan StudioLocationSeeder dulu.');
            return;
        }

        $films = Film::where('status', 'now_showing')
            ->orderBy('judul')
            ->get();

        if ($films->isEmpty()) {
            $this->command->warn('Tidak ada film dengan status now_showing.');
            return;
        }

        $showtimes = [
            '10:00:00' => 40000,
            '13:00:00' => 45000,
            '16:00:00' => 50000,
            '19:00:00' => 55000,
        ];

        $total = 0;

        foreach ($cinemas as $cinemaIndex => $cinema) {
            for ($day = 0; $day < 7; $day++) {
                $tanggal = Carbon::today()->addDays($day)->format('Y-m-d');

                $slotIndex = 0;

                foreach ($showtimes as $time => $harga) {
                    $filmIndex = ($cinemaIndex + $slotIndex + $day) % $films->count();
                    $film = $films[$filmIndex];

                    $waktuMulai = Carbon::parse($tanggal . ' ' . $time);
                    $waktuSelesai = $waktuMulai->copy()->addMinutes((int) $film->durasi + 15);

                    Schedule::updateOrCreate(
                        [
                            'studio_id' => $cinema->id,
                            'tanggal' => $tanggal,
                            'waktu_mulai' => $waktuMulai->format('H:i:s'),
                        ],
                        [
                            'film_id' => $film->id,
                            'waktu_selesai' => $waktuSelesai->format('H:i:s'),
                            'harga' => $harga,
                        ]
                    );

                    $slotIndex++;
                    $total++;
                }
            }
        }

        $this->command->info("✅ {$total} jadwal tayang berhasil dibuat/diperbarui berdasarkan film yang ada.");
    }
}