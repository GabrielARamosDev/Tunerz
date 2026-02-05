<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Vehicle;

class VehiclesSeeder extends Seeder
{
    public function run(): void
    {
        Vehicle::insert([
            [
                'brand' => 'Chevrolet',
                'model' => 'Astra',
                'model_year'  => 2004,
                'trim'  => 'CD 2.0 8V',
                'body_type'  => 'Sedan',
                'drivetrain'  => 'FWD',
                'fuel_type'  => 'Gasoline',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand' => 'Volkswagen',
                'model' => 'Golf',
                'model_year'  => 2001,
                'trim'  => '1.6',
                'body_type'  => 'Hatchback',
                'drivetrain'  => 'FWD',
                'fuel_type'  => 'Gasoline',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
