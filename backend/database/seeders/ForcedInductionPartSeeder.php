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
                
            ],
        ];

        foreach ($induction_parts as $i) {
            ForcedInductionPart::updateOrCreate(
                ['forcedInduction_id' => $i['forcedInduction_id']],  // chave única para evitar duplicatas
                $i     // campos a atualizar
            );
        }
    }
}
