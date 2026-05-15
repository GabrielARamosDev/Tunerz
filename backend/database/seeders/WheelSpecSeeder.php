<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WheelSpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $specs = [
                [
                    'wheel_id' => 1,
                    'tire_width_mm' => 0,
                    'tire_profile' => 0,
                    'wheel_radius_in' => 0,
                    'wheel_material' => 'steel',
                    'expected_pressure_bar' => 32,
                ],
            ];

            foreach ($specs as $spec) {
                \App\Models\WheelSpec::updateOrCreate(
                    ['wheel_id' => $spec['wheel_id']],
                    $spec
                );
            }
    }
}
