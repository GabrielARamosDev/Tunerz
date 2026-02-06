<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\EngineSpec;

class EngineSpecsSeeder extends Seeder
{
    public function run(): void
    {
        $specs = [
            [
                'engine_id' => 1,
                'place' => 'Front',
                'orientation' => 'Transverse',
                'cylinder_configuration' => 'Inline',
                'cylinders_count' => 4,
                'valves_per_cylinder' => 2,
                'valve_tappet' => 'Hydraulic',
                'compression_ratio' => 9.8,
                'aspiration' => 'NA',
                'fuel_system' => 'mpfi',
                'camshaft_type' => 'DOHC',
                'command_drive' => 'Belt',
                'bore_mm' => 82,
                'stroke_mm' => 93.5,
                'stock_power_hp' => 116,
                'stock_power_rpm' => 5200,
                'stock_torque_nm' => 178,
                'stock_torque_rpm' => 4000,
                'specific_power_hp_per_liter' => 58,
                'specific_torque_nm_per_liter' => 89,
                'power_to_weight_ratio' => 0.09,
                'torque_to_weight_ratio' => 0.14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'engine_id' => 2,
                'place' => 'Front',
                'orientation' => 'Transverse',
                'cylinder_configuration' => 'Inline',
                'cylinders_count' => 4,
                'valves_per_cylinder' => 2,
                'valve_tappet' => 'Hydraulic',
                'compression_ratio' => 9.8,
                'aspiration' => 'NA',
                'fuel_system' => 'mpfi',
                'camshaft_type' => 'DOHC',
                'command_drive' => 'Belt',
                'bore_mm' => 82,
                'stroke_mm' => 93.5,
                'stock_power_hp' => 116,
                'stock_power_rpm' => 5200,
                'stock_torque_nm' => 178,
                'stock_torque_rpm' => 4000,
                'specific_power_hp_per_liter' => 58,
                'specific_torque_nm_per_liter' => 89,
                'power_to_weight_ratio' => 0.09,
                'torque_to_weight_ratio' => 0.14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'engine_id' => 3,
                'place' => 'Front',
                'orientation' => 'Transverse',
                'cylinder_configuration' => 'Inline',
                'cylinders_count' => 4,
                'valves_per_cylinder' => 2,
                'valve_tappet' => 'Hydraulic',
                'compression_ratio' => 9.8,
                'aspiration' => 'NA',
                'fuel_system' => 'mpfi',
                'camshaft_type' => 'DOHC',
                'command_drive' => 'Belt',
                'bore_mm' => 82,
                'stroke_mm' => 93.5,
                'stock_power_hp' => 116,
                'stock_power_rpm' => 5200,
                'stock_torque_nm' => 178,
                'stock_torque_rpm' => 4000,
                'specific_power_hp_per_liter' => 58,
                'specific_torque_nm_per_liter' => 89,
                'power_to_weight_ratio' => 0.09,
                'torque_to_weight_ratio' => 0.14,
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
