<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuspensionPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $parts = [
                [
                    'suspension_id' => 1,
                    'spring_type' => 'coil',
                    'spring_material' => 'steel',
                    'damper_type' => 'telescopic',
                    'damper_material' => 'aluminum',
                    'has_abs' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            foreach ($parts as $part) {
                \App\Models\SuspensionPart::updateOrCreate(
                    ['suspension_id' => $part['suspension_id']],
                    $part
                );
            }
    }
}
