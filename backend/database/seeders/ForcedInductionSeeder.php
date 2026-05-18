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
                
            ],
        ];

        foreach ($inductions as $i) {
            ForcedInduction::updateOrCreate(
                ['code' => $i['code']],  // chave única para evitar duplicatas
                $i     // campos a atualizar
            );
        }
    }
}
