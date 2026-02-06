<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Vehicle;

class VehicleEngineSeeder extends Seeder
{
    public function run(): void
    {
        $relations = [
            [
                'vehicle_id' => 1,
                'engine_id' => 1,
            ],
            [
                'vehicle_id' => 2,
                'engine_id' => 2,
            ],
            [
                'vehicle_id' => 1,
                'engine_id' => 3,
            ],
        ];

        DB::table('vehicle_engine')->truncate();

        foreach ($relations as $r) {
            $vehicle = Vehicle::find($r['vehicle_id']);
            $vehicle->engines()->attach($r['engine_id']);
        }
    }
}
