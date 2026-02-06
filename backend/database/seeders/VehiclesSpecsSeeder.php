<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\VehicleSpec;

class VehiclesSpecsSeeder extends Seeder
{
    public function run(): void
    {
        $specs = [
            [
                'vehicle_id' => 1,
                'drivetrain'  => 'FWD',
                'transmission'  => 'Manual',
                'price'  => 24025,
                'price_currency'  => 'BRL',
                'weight' => 1130,
                'weight_unit' => 'kg',
                'width' => 1709,
                'length' => 4199,
                'height' => 1431,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vehicle_id' => 2,
                'drivetrain'  => 'FWD',
                'transmission'  => 'Manual',
                'price'  => 22000,
                'price_currency'  => 'BRL',
                'weight' => 1250,
                'weight_unit' => 'kg',
                'width' => 1759,
                'length' => 4024,
                'height' => 1468,
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
