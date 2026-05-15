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
                    'stock_power_hp' => 116,
                    'stock_power_rpm' => 5200,
                    'stock_torque_nm' => 178,
                    'stock_torque_rpm' => 4000,
                    'stock_power_to_weight_ratio' => 0.09,
                    'stock_torque_to_weight_ratio' => 0.14,
                    'stock_redline_rpm' => 6400,
                    'stock_idle_rpm' => 700,
                    'cylinders_count' => 4,
                    'piston_bore_mm' => 82.00,
                    'piston_stroke_mm' => 93.50,
                    'displacement_cc' => 1998,
                    'compression_ratio' => 9.80,
                    'valve_count' => 8,
                    'intake_valve_diameter_mm' => 33.50,
                    'intake_valve_seat_angle' => 45,
                    'exhaust_valve_diameter_mm' => 29.00,
                    'exhaust_valve_seat_angle' => 45,
                    'carburator_barrel_count' => 0, 
                    'air_flow_cfm' => 380.5,
                    'max_safe_boost_bar' => 1.5,
                    'fuel_injection_time_ms' => 2.0,
                    'fuel_flowrate_cc_min' => 200,
                    'fuel_pressure_bar' => 2.8,
                    'air_fuel_ratio' => 14.7,
                    'thermal_efficiency' => 0.35,
                    'coolant_capacity_l' => 7.5,
                    'oil_capacity_l' => 4.2,
                    'length_mm' => 545.0,
                    'width_mm' => 658.0,
                    'height_mm' => 748.0,
                    'weight_kg' => 125.5,
                    'created_at' => now(),
                    'updated_at' => now(),
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
