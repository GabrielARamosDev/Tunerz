<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransmissionSpecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $specs = [
                [
                    'transmission_id' => 1,
                    'gear_ratio_1' => 3.82,
                    'gear_ratio_2' => 2.10,
                    'gear_ratio_3' => 1.45,
                    'gear_ratio_4' => 1.03,
                    'gear_ratio_5' => 0.84,
                    'final_drive_ratio' => 4.10,
                    'weight_kg' => 48.0,
                    'max_torque_nm' => 350,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($specs as $spec) {
                \App\Models\TransmissionSpec::updateOrCreate(
                    ['transmission_id' => $spec['transmission_id']],
                    $spec
                );
            }
    }
}
