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
                'generation' => 2,
                'architecture' => 'inline',
                'rotation_direction' => 'transverse',
            ],
        ];

        foreach ($engines as $e) {
            Engine::updateOrCreate(
                // chave única para evitar duplicatas
                [
                    'code' => $e['code'], 
                    'manufacturer' => $e['manufacturer'], 
                ], 
                $e     // campos a atualizar
            );
        }
    }
}
