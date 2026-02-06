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
                'brand' => 'Chevrolet',
                'model' => 'Astra',
                'model_year'  => 2004,
                'trim'  => 'CD 2.0 8V',
                'body_type'  => 'Sedan',
                'image_url' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand' => 'Volkswagen',
                'model' => 'Golf',
                'model_year'  => 2001,
                'trim'  => '1.6',
                'body_type'  => 'Hatchback',
                'image_url' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        foreach ($vehicles as $v) {
            Vehicle::updateOrCreate(
                [
                    'brand' => $v['brand'], 
                    'model' => $v['model'], 
                    'model_year' => $v['model_year'], 
                    'trim' => $v['trim']
                ],  // chave única para evitar duplicatas
                $v     // campos a atualizar
            );
        }
    }
}
