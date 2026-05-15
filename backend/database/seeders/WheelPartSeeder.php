<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WheelPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $wheelParts = [
                [
                    'wheel_id' => 1,
                    'tire_material' => 'rubber (synthetic)',
                    'wheel_material' => 'steel',
                ],
            ];

            foreach ($wheelParts as $part) {
                \App\Models\WheelPart::updateOrCreate(
                    ['wheel_id' => $part['wheel_id']],
                    $part
                );
            }
    }
}
