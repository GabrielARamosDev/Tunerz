<?php

namespace Database\Seeders;

use App\Models\ForcedInduction;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForcedInductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inductions = [
            [
                'code' => 'TX050',
                'name' => 'Stage 1 Turbo Kit',
                'manufacturer' => 'Garret',
            ],
        ];

        foreach ($inductions as $i) {
            ForcedInduction::updateOrCreate(
                // chave única para evitar duplicatas
                [
                    'code' => $i['code'], 
                    'manufacturer' => $i['manufacturer'], 
                ], 
                $i     // campos a atualizar
            );
        }
    }
}
