<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            FilmSeeder::class,
            StudioSeeder::class,
            SeatSeeder::class,
            ScheduleSeeder::class,
        ]);
    }
}