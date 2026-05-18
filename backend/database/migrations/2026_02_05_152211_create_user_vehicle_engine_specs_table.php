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
        Schema::create('user_vehicle_engine_specs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained()
                ->cascadeOnDelete();

            /* ================================================ */
            $table->integer('power_hp')->nullable();
            $table->integer('power_rpm')->nullable();
            $table->integer('torque_nm')->nullable();
            $table->integer('torque_rpm')->nullable();

            $table->double('power_to_weight_ratio', 8, 4)->nullable();
            $table->double('torque_to_weight_ratio', 8, 4)->nullable();

            $table->integer('idle_rpm');
            $table->integer('redline_rpm');
            /* ================================================ */

            $table->integer('cylinders_count');
            $table->double('piston_bore_mm', 5, 2);
            $table->double('piston_stroke_mm', 5, 2);
            $table->integer('displacement_cc');
            $table->double('compression_ratio', 4, 2);
            
            $table->integer('valve_count');
            $table->double('intake_valve_diameter_mm', 5, 2);
            $table->integer('intake_valve_seat_angle');
            $table->double('exhaust_valve_diameter_mm', 5, 2);
            $table->integer('exhaust_valve_seat_angle');

            /* ================================================ */
            //Only aplicable if: fuel_system = 'carburator'
            $table->integer('carburator_barrel_count') 
                ->nullable()
                ->default(0);
            /* ================================================ */
            
            $table->double('fuel_injection_time_ms', 6, 2);
            $table->double('fuel_flowrate_cc_min', 6, 2);
            $table->double('fuel_pressure_bar', 5, 2);
            $table->double('air_fuel_ratio', 5, 2);

            $table->double('intake_lenght_cm', 6, 2);
            $table->double('intake_diameter_in', 5, 2);
            $table->double('air_flow_cfm', 8, 2)->nullable();

            $table->double('thermal_efficiency', 4, 2);
            $table->double('coolant_capacity_l', 4, 2);
            $table->double('oil_capacity_l', 4, 2);

            $table->double('length_mm', 6, 2)->default(0);
            $table->double('width_mm', 6, 2)->default(0);
            $table->double('height_mm', 6, 2)->default(0);

            $table->double('weight_kg', 6, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicle_engine_specs');
    }
};
