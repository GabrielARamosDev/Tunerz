<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\EngineSpec;
use App\Models\EngineStage;

class EngineStagesSeeder extends Seeder
{
    public function run(): void
    {
        $stages = [
            [
                'engine_id' => 1,
                'modification_type_id' => null,
                'name' => 'NA',
                'boost_pressure' => 0.0,
                'expected_power' => 0, 
                'expected_torque' => 0, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'engine_id' => 2,
                'modification_type_id' => null,
                'name' => 'NA',
                'boost_pressure' => 0.0,
                'expected_power' => 0, 
                'expected_torque' => 0, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'engine_id' => 3,
                'modification_type_id' => null,
                'name' => 'NA',
                'boost_pressure' => 0.0,
                'expected_power' => 0, 
                'expected_torque' => 0, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($stages as $es) {
            EngineStage::updateOrCreate(
                ['engine_id' => $es['engine_id']],  // chave única para evitar duplicatas
                $es     // campos a atualizar
            );
        }
    }
}
