<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $transmissions = [
                [
                    'name' => '5-Speed Manual',
                    'type' => 'manual',
                    'gears_count' => 5,
                    'manufacturer' => 'ZF',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($transmissions as $transmission) {
                \App\Models\Transmission::updateOrCreate(
                    ['name' => $transmission['name']],
                    $transmission
                );
            }
    }
}
