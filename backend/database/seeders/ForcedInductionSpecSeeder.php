<?php

namespace Database\Seeders;

use App\Models\ForcedInduction;
use App\Models\ForcedInductionSpec;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForcedInductionSpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $induction_specs = [
            [
                
            ],
        ];

        foreach ($induction_specs as $i) {
            ForcedInductionSpec::updateOrCreate(
                ['forcedInduction_id' => $i['forcedInduction_id']],  // chave única para evitar duplicatas
                $i     // campos a atualizar
            );
        }
    }
}
