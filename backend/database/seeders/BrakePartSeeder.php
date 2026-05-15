<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrakePartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $parts = [
                [
                    'brake_id' => 1,
                    'rotor_type' => 'ventilated',
                    'rotor_material' => 'cast iron',
                    'caliper_type' => 'dual piston',
                    'caliper_material' => 'aluminum alloy',
                    'pad_type' => 'semi-metallic',
                    'pad_material' => 'ceramic',
                    'dust_shield' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($parts as $part) {
                \App\Models\BrakePart::updateOrCreate(
                    ['brake_id' => $part['brake_id']],
                    $part
                );
            }
    }
}
