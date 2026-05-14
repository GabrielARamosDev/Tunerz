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
        Schema::create('user_vehicle_specs', function (Blueprint $table) {
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

            $table->enum('platform', [
                
            ]);
            
            $table->double('wheel_base_mm', 10, 2)->nullable();

            $table->enum('front_wheel_width', [
                
            ])->nullable();
            $table->enum('front_wheel_profile', [
                
            ])->nullable();
            $table->enum('front_wheel_radius', [
                
            ])->nullable();
            $table->enum('rear_wheel_width', [
                
            ])->nullable();
            $table->enum('rear_wheel_profile', [
                
            ])->nullable();
            $table->enum('rear_wheel_radius', [
                
            ])->nullable();

            $table->enum('wheel_material', [

            ])->nullable();

            $table->double('length_mm', 10, 2)->nullable();
            $table->double('width_mm', 10, 2)->nullable();
            $table->double('height_mm', 10, 2)->nullable();

            $table->double('front_track_mm', 10, 2)->nullable();
            $table->double('hear_track_mm', 10, 2)->nullable();

            $table->double('weight_kg', 10, 2)->nullable();

            $table->double('fuel_tank_l', 10, 2)->nullable();

            $table->double('drag_coefficient', 10, 2)->nullable();

            $table->unique('vehicle_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicle_specs');
    }
};
