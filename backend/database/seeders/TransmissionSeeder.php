<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $transmissions = [
                [
                    'code' => '',
                    'name' => '5-Speed Manual',
                    'manufacturer' => 'ZF',
                    'type' => 'manual',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($transmissions as $t) {
                \App\Models\Transmission::updateOrCreate(
                    // chave única para evitar duplicatas
                    [
                        'code' => $t['code'], 
                        'manufacturer' => $t['manufacturer'], 
                    ], 
                    $t
                );
            }
    }
}
