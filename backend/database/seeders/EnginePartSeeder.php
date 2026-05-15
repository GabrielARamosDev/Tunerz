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
                    'block_material' => 'cast iron',
                    'head_material' => 'aluminum alloy',
                    'piston_head_type' => 'flat',
                    'piston_head_material' => 'forged aluminum',
                    'piston_conrod_type' => 'I-beam',
                    'piston_conrod_material' => 'forged steel',
                    'camshaft_config' => 'dohc',
                    'camshaft_actuation' => 'mechanical',
                    'camshaft_type' => 'roller',
                    'camshaft_material' => 'cast iron',
                    'valve_type' => 'poppet',
                    'valve_material' => 'stainless steel',
                    'fuel_type' => 'flex',
                    'fuel_system' => 'mpfi',
                    'carburator_system' => null, 
                    'aspiration' => 'NA',
                    'twin_turbocharged_config' => null,
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
