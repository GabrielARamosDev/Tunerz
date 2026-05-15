<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnginePartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $engineParts = [
                [
                    'engine_id' => 1,
                    'piston_head_type' => 'flat',
                    'piston_head_material' => 'forged aluminum',
                    'piston_conrod_type' => 'I-beam',
                    'piston_conrod_material' => 'forged steel',
                    'piston_bore_mm' => 82.00,
                    'piston_stroke_mm' => 93.50,
                    'compression_ratio' => 9.80,
                    'displacement_cc' => 1998,
                    'camshaft_type' => 'roller',
                    'camshaft_material' => 'cast iron',
                    'valve_type' => 'poppet',
                    'valve_material' => 'stainless steel',
                    'intake_valve_diameter_mm' => 33.50,
                    'intake_valve_seat_angle' => 45,
                    'exhaust_valve_diameter_mm' => 29.00,
                    'exhaust_valve_seat_angle' => 45,
                    'valve_control_type' => 'hydraulic',
                    'valve_control_material' => 'steel',
                    'has_VVT' => false,
                    'has_VVL' => false,
                    'aspiration' => 'NA',
                    'max_safe_boost_bar' => 1.5,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($engineParts as $part) {
                \App\Models\EnginePart::updateOrCreate(
                    ['engine_id' => $part['engine_id']],
                    $part
                );
            }
    }
}
