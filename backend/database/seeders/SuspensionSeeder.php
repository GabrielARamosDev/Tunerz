<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuspensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $suspensions = [
                [
                    'code' => '',
                    'name' => 'MacPherson Strut',
                    'manufacturer' => 'KW',
                    'type' => 'independent',
                    'configuration' => 'double wishbone',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($suspensions as $suspension) {
                \App\Models\Suspension::updateOrCreate(
                    ['name' => $suspension['name']],
                    $suspension
                );
            }
    }
}
