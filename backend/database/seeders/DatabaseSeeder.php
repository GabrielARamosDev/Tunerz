<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RolesSeeder::class,
            UserSeeder::class,
            UserRole::class,
            ###
            EngineSeeder::class,
            EnginePartSeeder::class,
            EngineSpecSeeder::class,
            TransmissionSeeder::class,
            TransmissionPartSeeder::class,
            TransmissionSpecSeeder::class,
            BrakeSeeder::class,
            BrakePartSeeder::class,
            BrakeSpecSeeder::class,
            SuspensionSeeder::class,
            SuspensionPartSeeder::class,
            SuspensionSpecSeeder::class,
            WheelSeeder::class,
            WheelPartSeeder::class,
            WheelSpecSeeder::class,
            ###
            VehicleSeeder::class,
            VehicleSpecSeeder::class,
        ]);
    }
}
