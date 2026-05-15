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
                    'air_flow_cfm' => 380.5,
                    'fuel_pressure_bar' => 2.8,
                    'thermal_efficiency' => 0.35,
                    'oil_capacity_l' => 4.2,
                    'coolant_capacity_l' => 7.5,
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
