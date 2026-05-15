<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrakeSpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $specs = [
                [
                    'brake_id' => 1,
                    'rotor_diameter_mm' => 278,
                    'rotor_thickness_mm' => 25,
                    'pad_thickness_mm' => 12,
                    'max_force_kn' => 7.8,
                    'friction_coefficient' => 0.35,
                    'weight_kg' => 3.2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($specs as $spec) {
                \App\Models\BrakeSpec::updateOrCreate(
                    ['brake_id' => $spec['brake_id']],
                    $spec
                );
            }
    }
}
