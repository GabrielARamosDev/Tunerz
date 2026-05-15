<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuspensionSpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $specs = [
                [
                    'suspension_id' => 1,
                    'spring_constant_nm' => 18000,
                    'damping_ratio' => 0.45,
                    'ride_height_mm' => 185,
                    'ground_clearance_mm' => 120,
                    'camber_angle_deg' => -0.5,
                    'caster_angle_deg' => 3.5,
                    'toe_in_mm' => 2.0,
                    'stabilizer_diameter_mm' => 24,
                    'weight_kg' => 65.0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($specs as $spec) {
                \App\Models\SuspensionSpec::updateOrCreate(
                    ['suspension_id' => $spec['suspension_id']],
                    $spec
                );
            }
    }
}
