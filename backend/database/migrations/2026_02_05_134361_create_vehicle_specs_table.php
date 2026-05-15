<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_specs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('body_type', [
                'sedan',
                'hatchback',
                'hothatch',
                'coupe',
                'convertible',
                'targa',
                'suv',
                'pickup',
                'wagon',
                'van',
            ]);

            $table->enum('drivetrain', [
                'fwd', // front-wheel drive
                'rwd', // rear-wheel drive
                'awd', // all-wheel drive
                '4wd', // four-wheel drive
            ]);

            $table->double('wheel_base_mm', 10, 2)->default(0);

            $table->integer('front_tire_width_mm')->default(165);
            $table->integer('front_tire_profile')->default(60);
            $table->integer('front_wheel_radius_in')->default(15);
            
            $table->integer('rear_tire_width_mm')->default(165);
            $table->integer('rear_tire_profile')->default(60);
            $table->integer('rear_wheel_radius_in')->default(15);

            $table->enum('wheel_material', [
                'steel',
                'aluminum alloy',
                'forged aluminum',
                'titanium',
                'carbon fiber',
                'magnesium',
            ])->nullable();

            $table->double('length_mm', 10, 2)->default(0);
            $table->double('width_mm', 10, 2)->default(0);
            $table->double('height_mm', 10, 2)->default(0);

            $table->double('front_track_mm', 10, 2)->default(0);
            $table->double('rear_track_mm', 10, 2)->default(0);

            $table->double('weight_kg', 10, 2)->default(0);

            $table->double('fuel_tank_l', 5, 2)->default(0);

            $table->double('drag_coefficient', 10, 2)->default(0);

            $table->unique('vehicle_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_specs');
    }
};
