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
        Schema::create('steering_system_specs', function (Blueprint $table) {
            $table->id();

            $table->double('front_suspension_height');
            $table->double('rear_suspension_height');

            $table->double('front_tire_pressure_bar');
            $table->double('rear_tire_pressure_bar');

            $table->double('front_wheel_camber');
            $table->double('rear_wheel_camber');
            
            $table->double('front_wheel_toe');
            $table->double('rear_wheel_toe');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steering_system_specs');
    }
};
