<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleEngine;

class VehicleEngineSeeder extends Seeder
{
    public function run(): void
    {
        VehicleEngine::insert([
            [
                'vehicle_id' => 1,
                'engine_id' => 1,
            ],
            [
                'vehicle_id' => 2,
                'engine_id' => 2,
            ],
        ]);
    }
}
