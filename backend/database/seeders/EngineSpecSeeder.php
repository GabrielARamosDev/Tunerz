<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\EngineSpec;

class EngineSpecSeeder extends Seeder
{
    public function run(): void
    {
        $specs = [
            [
                'engine_id' => 1,
                'bore_mm' => 82,
                'stroke_mm' => 93.5,
                'compression_ratio' => 9.8,
                'stock_power_hp' => 116,
                'stock_power_rpm' => 5200,
                'stock_torque_nm' => 178,
                'stock_torque_rpm' => 4000,
                'power_to_weight_ratio' => 0.09,
                'torque_to_weight_ratio' => 0.14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($specs as $es) {
            EngineSpec::updateOrCreate(
                ['engine_id' => $es['engine_id']],  // chave única para evitar duplicatas
                $es     // campos a atualizar
            );
        }
    }
}
