<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Engine;

class EngineSeeder extends Seeder
{
    public function run(): void
    {
        $engines = [
            [
                'name' => 'Família II',
                'code' => 'X20XEV',
                'manufacturer' => 'General Motors',
                'generation' => '2ª',
                    'architecture' => 'inline',
                    'rotation_direction' => 'transverse',
                    'cylinders_count' => 4,
                    'valve_count' => 16,
                    'camshaft_type' => 'dohc',
                    'aspiration' => 'NA',
                    'fuel_system' => 'mpfi',
                    'fuel_type' => 'flex',
                    'block_material' => 'cast iron',
                    'head_material' => 'aluminum billet',
                    'length_mm' => 545.0,
                    'width_mm' => 658.0,
                    'height_mm' => 748.0,
                    'weight_kg' => 125.5,
            ],
        ];

        foreach ($engines as $e) {
            Engine::updateOrCreate(
                ['code' => $e['code']],  // chave única para evitar duplicatas
                $e     // campos a atualizar
            );
        }
    }
}
