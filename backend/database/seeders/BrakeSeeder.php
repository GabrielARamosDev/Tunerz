<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $brakes = [
                [
                    'name' => 'Ventilated Disc Brake System',
                    'type' => 'disc',
                    'manufacturer' => 'Brembo',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($brakes as $brake) {
                \App\Models\Brake::updateOrCreate(
                    ['name' => $brake['name']],
                    $brake
                );
            }
    }
}
