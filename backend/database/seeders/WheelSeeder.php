<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WheelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $wheels = [
                [
                    'code' => '7J ET50',
                    'name' => 'SuperTurismo GT',
                    'manufacturer' => 'O.Z',
                ],
            ];

            foreach ($wheels as $w) {
                \App\Models\Wheel::updateOrCreate(
                    // chave única para evitar duplicatas
                    [
                        'code' => $w['code'], 
                        'manufacturer' => $w['manufacturer'], 
                    ], 
                    $w
                );
            }
    }
}
