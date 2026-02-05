<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Engine;

class EnginesSeeder extends Seeder
{
    public function run(): void
    {
        Engine::insert([
            [
                'code' => 'X20XEV',
                'manufacturer' => 'General Motors',
                'displacement' => 1998,
                'cylinders' => 4,
                'valve_count' => 8,
                'compression_ratio' => 9.8,
                'aspiration' => 'NA',
                'stock_power_hp' => 116,
                'stock_torque_nm' => 178,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'EA888',
                'manufacturer' => 'Volkswagen',
                'displacement' => 1998,
                'cylinders' => 4,
                'valve_count' => 16,
                'compression_ratio' => 10.5,
                'aspiration' => 'NA',
                'stock_power_hp' => 150,
                'stock_torque_nm' => 210,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
