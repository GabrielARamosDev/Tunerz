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
                    'synchro_type' => 'cone',
                    'material_case' => 'aluminum',
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
