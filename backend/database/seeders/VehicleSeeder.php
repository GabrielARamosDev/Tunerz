<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
                'manufacturer' => 'Chevrolet',
                'model' => 'Astra',
                'trim'  => 'CD',
                'year'  => 2004,
                'generation' => 2, 
                'engine_id' => 1,
                'transmission_id' => 1,
                'front_suspension_id' => 1,
                'rear_suspension_id' => 1,
                'front_brake_id' => 1,
                'rear_brake_id' => 1,
                'front_wheel_id' => 1,
                'rear_wheel_id' => 1,
                'image_url' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($vehicles as $v) {
            Vehicle::updateOrCreate(
                [
                    'manufacturer' => $v['manufacturer'], 
                    'model' => $v['model'], 
                    'year' => $v['year'], 
                    'trim' => $v['trim'],
                    'engine_id' => $v['engine_id']
                ],  // chave única para evitar duplicatas
                $v     // campos a atualizar
            );
        }
    }
}
