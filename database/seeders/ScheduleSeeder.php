<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Film;
use App\Models\Studio;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $films   = Film::all();
        $studios = Studio::all();

        if ($films->isEmpty()) {
            $this->command->error('❌ Tidak ada film! Jalankan FilmSeeder dulu.');
            return;
        }

        if ($studios->isEmpty()) {
            $this->command->error('❌ Tidak ada studio! Jalankan StudioSeeder dulu.');
            return;
        }

        // Jadwal tayang per film (jam mulai => durasi menit)
        $jamTayang = [
            '10:00' => 'pagi',
            '13:00' => 'siang',
            '16:00' => 'sore',
            '19:00' => 'malam',
            '21:30' => 'malam',
        ];

        // Harga berdasarkan waktu
        $hargaMap = [
            'pagi'  => 40000,
            'siang' => 45000,
            'sore'  => 50000,
            'malam' => 55000,
        ];

        $count = 0;

        // Buat jadwal untuk 7 hari ke depan (hari ini + 6 hari)
        for ($hari = 0; $hari <= 6; $hari++) {
            $tanggal = Carbon::today()->addDays($hari);

            foreach ($films as $filmIndex => $film) {
                // Tiap film dapat 1 studio (rotasi)
                $studio = $studios[$filmIndex % $studios->count()];

                // Pilih 3-4 jam tayang per hari
                $selectedJam = array_slice(array_keys($jamTayang), 0, ($filmIndex % 2 === 0) ? 4 : 3);

                foreach ($selectedJam as $jam) {
                    $waktuMulai   = Carbon::parse($tanggal->format('Y-m-d') . ' ' . $jam);
                    $waktuSelesai = $waktuMulai->copy()->addMinutes($film->durasi + 15); // +15 menit iklan
                    $sesi         = $jamTayang[$jam];
                    $harga        = $hargaMap[$sesi];

                    // Hindari jadwal bentrok di studio yang sama
                    $bentrok = Schedule::where('studio_id', $studio->id)
                        ->where('tanggal', $tanggal->format('Y-m-d'))
                        ->where(function ($q) use ($waktuMulai, $waktuSelesai) {
                            $q->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                              ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai]);
                        })->exists();

                    if (!$bentrok) {
                        Schedule::create([
                            'film_id'      => $film->id,
                            'studio_id'    => $studio->id,
                            'tanggal'      => $tanggal->format('Y-m-d'),
                            'waktu_mulai'  => $waktuMulai->format('H:i:s'),
                            'waktu_selesai'=> $waktuSelesai->format('H:i:s'),
                            'harga'        => $harga,
                        ]);
                        $count++;
                    }
                }
            }
        }

        $this->command->info('✅ Schedule seeder selesai: ' . $count . ' jadwal ditambahkan.');
    }
}