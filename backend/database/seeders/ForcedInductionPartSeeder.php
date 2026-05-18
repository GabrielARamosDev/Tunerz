<?php

namespace Database\Seeders;

use App\Models\ForcedInduction;
use App\Models\ForcedInductionPart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForcedInductionPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $induction_parts = [
            [
                'forced_induction_id' => 1, 
                'turbine_material' => null, 
                'turbine_blade_type' => null, 
                'compressor_material' => null, 
                'compressor_design' => null, 
                'supercharger_type' => null, 
                'supercharger_drive' => null, 
                'supercharger_material' => null, 
                'intercooler_type' => null, 
                'intercooler_material' => null, 
                'wastegate_type' => null, 
                'wastegate_material' => null, 
                'blow_off_valve_type' => null, 
                'blow_off_valve_material' => null, 
                'intake_manifold_material' => 'aluminum', 
                'piping_material' => 'aluminum', 
            ],
        ];

        foreach ($induction_parts as $i) {
            ForcedInductionPart::updateOrCreate(
                ['forced_induction_id' => $i['forced_induction_id']],  // chave única para evitar duplicatas
                $i     // campos a atualizar
            );
        }
    }
}
