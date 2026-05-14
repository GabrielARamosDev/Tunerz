<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\EngineSpec;

class EngineSpecSeeder extends Seeder
{
    public function run(): void
    {
        $specs = [
            [
                'engine_id' => 1,
                    'displacement_cc' => 1998,
                    'bore_mm' => 82.0,
                    'stroke_mm' => 93.5,
                    'compression_ratio' => 9.80,
                    'stock_power_hp' => 116,
                    'stock_power_rpm' => 5200,
                    'stock_torque_nm' => 178,
                    'stock_torque_rpm' => 4000,
                    'redline_rpm' => 6400,
                    'idle_rpm' => 700,
                    'max_safe_boost_bar' => 1.5,
                    'air_flow_cfm' => 380.5,
                    'fuel_pressure_bar' => 2.8,
                    'thermal_efficiency' => 0.35,
                    'oil_capacity_l' => 4.2,
                    'coolant_capacity_l' => 7.5,
            ],
        ];
        
        foreach ($specs as $es) {
            EngineSpec::updateOrCreate(
                ['engine_id' => $es['engine_id']],  // chave única para evitar duplicatas
                $es     // campos a atualizar
            );
        }
    }
}
