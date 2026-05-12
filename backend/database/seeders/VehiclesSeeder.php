<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Vehicle;

class VehiclesSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
                'manufacturer' => 'Chevrolet',
                'model' => 'Astra',
                'year'  => 2004,
                'trim'  => 'CD 2.0 8V',
                'engine_id' => 1,
                'body_type'  => 'Sedan',
                'image_url' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'manufacturer' => 'Volkswagen',
                'model' => 'Golf',
                'year'  => 2001,
                'trim'  => '1.6',
                'engine_id' => 2,
                'body_type'  => 'Hatchback',
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
