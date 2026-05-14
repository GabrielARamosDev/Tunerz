<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransmissionPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $parts = [
                [
                    'transmission_id' => 1,
                    'clutch_type' => 'dry single',
                    'clutch_diameter_mm' => 215,
                    'synchro_type' => 'cone',
                    'material_case' => 'aluminum',
                    'oil_type' => '75W-90',
                    'oil_capacity_l' => 1.8,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($parts as $part) {
                \App\Models\TransmissionPart::updateOrCreate(
                    ['transmission_id' => $part['transmission_id']],
                    $part
                );
            }
    }
}
