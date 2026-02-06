<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Engine;

class EnginesSeeder extends Seeder
{
    public function run(): void
    {
        $engines = [
            [
                'code' => 'X20XEV',
                'manufacturer' => 'General Motors',
                'displacement' => 1998,
                'valve_count' => 8,
                'propulsion' => 'Combustion',
                'fuel_type' => 'Gasoline',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'EA888',
                'manufacturer' => 'Volkswagen',
                'displacement' => 1998,
                'valve_count' => 16,
                'propulsion' => 'Combustion',
                'fuel_type' => 'Gasoline',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'F22SE',
                'manufacturer' => 'General Motors',
                'displacement' => 2203,
                'valve_count' => 8,
                'propulsion' => 'Combustion',
                'fuel_type' => 'Gasoline',
                'created_at' => now(),
                'updated_at' => now(),
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
