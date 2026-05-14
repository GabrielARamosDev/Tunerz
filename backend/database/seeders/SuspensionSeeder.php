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
                    'name' => 'MacPherson Strut',
                    'type' => 'independent',
                    'configuration' => 'double wishbone',
                    'manufacturer' => 'KW',
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
