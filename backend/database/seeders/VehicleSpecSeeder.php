<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\VehicleSpec;

class VehicleSpecSeeder extends Seeder
{
    public function run(): void
    {
        $specs = [
            [
                'vehicle_id' => 1,
                'body_type' => 'sedan',
                'drivetrain'  => 'fwd',
                'length_mm' => 4199,
                'width_mm' => 1709,
                'height_mm' => 1431,
                'wheel_base_mm' => 0,
                'front_track_mm' => 0,
                'rear_track_mm' => 0,
                'weight_kg' => 1130,
                'fuel_tank_l' => 40,
                'drag_coefficient' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($specs as $vs) {
            VehicleSpec::updateOrCreate(
                ['vehicle_id' => array_search($vs, $specs) + 1],  // chave única para evitar duplicatas
                $vs     // campos a atualizar
            );
        }
    }
}
