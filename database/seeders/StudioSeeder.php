<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Studio;

class StudioSeeder extends Seeder
{
    public function run(): void
    {
        $studios = [
            ['nama' => 'Studio 1', 'kapasitas' => 96],
            ['nama' => 'Studio 2', 'kapasitas' => 96],
            ['nama' => 'Studio 3', 'kapasitas' => 96],
        ];

        foreach ($studios as $studio) {
            Studio::create($studio);
        }

        $this->command->info('✅ Studio seeder selesai: ' . count($studios) . ' studio ditambahkan.');
    }
}