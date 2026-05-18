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
                'code' => 'GM_stock_0001',
                'name' => 'stock',
                'manufacturer' => 'GM',
                ###
                'type' => 'NA',
                'twin_turbo_config' => null,
                'twin_turbo_count' => null,
                'supercharger_config' => null,
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
