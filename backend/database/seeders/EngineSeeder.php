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
