<?php

namespace Database\Seeders;

use App\Models\ForcedInduction;
use App\Models\ForcedInductionSpec;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForcedInductionSpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $induction_specs = [
            [
                'forced_induction_id' => 1,
                ###
                'turbine_diameter_mm' => null,
                'compressor_diameter_mm' => null,
                'turbo_max_rpm' => null,
                ###
                'supercharger_displacement_cc' => null,
                'pulley_diameter_mm' => null,
                'pulley_ratio' => null,
                ###
                'intercooler_volume_l' => null,
                'intercooler_core_length_mm' => null,
                'intercooler_core_width_mm' => null,
                'intercooler_core_height_mm' => null,
                'intercooler_inlet_diameter_mm' => null,
                'intercooler_outlet_diameter_mm' => null,
                'intercooler_pressure_drop_bar' => null,
                ###
                'max_boost_bar' => null,
                'min_boost_bar' => null,
                'peak_boost_rpm' => null,
                'boost_response_ms' => null,
                'boost_ramp_time_s' => null,
                ###
                'max_inlet_temp_celsius' => null,
                'max_outlet_temp_celsius' => null,
                'intercooler_temp_drop_celsius' => null,
                ###
                'coolant_temp_celsius' => 95,
                'thermal_efficiency' => 0,
                ###
                'intake_lenght_cm' => 50,
                'intake_diameter_in' => 3,
                'air_flow_cfm' => 380.5,
                ###
                'boost_pressure_bar' => 0,
                'surge_margin_percent' => 0,
                'compressor_efficiency_percent' => null,
                'turbine_efficiency_percent' => null,
                'spool_time_ms' => null,
                'lag_ms' => null,
                ###
                'max_rpm' => null,
                'safe_rpm' => null,
                'weight_kg' => null,
            ],
        ];

        foreach ($induction_specs as $i) {
            ForcedInductionSpec::updateOrCreate(
                ['forced_induction_id' => $i['forced_induction_id']],  // chave única para evitar duplicatas
                $i     // campos a atualizar
            );
        }
    }
}
