<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Studio;

class StudioLocationSeeder extends Seeder
{
    public function run(): void
    {

        $cinemas = [
            [
                'nama' => 'CENTRAL LAMPUNG XXI',
                'city' => 'LAMPUNG',
                'address' => 'Central Plaza Lampung, Bandar Lampung',
                'kapasitas' => 320,
            ],
            [
                'nama' => 'MALL BOEMI KEDATON XXI',
                'city' => 'LAMPUNG',
                'address' => 'Mall Boemi Kedaton, Kedaton, Bandar Lampung',
                'kapasitas' => 420,
            ],
            [
                'nama' => 'CIPLAZ LAMPUNG XXI',
                'city' => 'LAMPUNG',
                'address' => 'Ciplaz Lampung, Bandar Lampung',
                'kapasitas' => 280,
            ],
        ];

        foreach ($cinemas as $cinema) {
            Studio::updateOrCreate(
                ['nama' => $cinema['nama']],
                [
                    'city' => $cinema['city'],
                    'address' => $cinema['address'],
                    'kapasitas' => $cinema['kapasitas'],
                ]
            );
        }


        Studio::whereIn('nama', ['Studio 1', 'Studio 2', 'Studio 3'])
            ->update([
                'city' => 'LAMPUNG',
            ]);
    }
}