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
        Schema::create('forced_induction_system_specs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('forced_induction_id')
                ->references('id')
                ->on('forced_induction_systems')
                ->constrained()
                ->cascadeOnDelete();

            /* ================================================ */
            /**
             * Turbocharger dimensions and specifications
             */
            $table->double('turbine_diameter_mm', 6, 2)->nullable();
            $table->double('compressor_diameter_mm', 6, 2)->nullable();
            $table->double('turbo_max_rpm', 8, 0)->nullable();
            /* ================================================ */

            /* ================================================ */
            /**
             * Supercharger dimensions and specifications
             */
            $table->double('supercharger_displacement_cc', 8, 2)->nullable();
            $table->double('pulley_diameter_mm', 6, 2)->nullable();
            $table->double('pulley_ratio', 4, 2)->nullable();
            /* ================================================ */

            /* ================================================ */
            /**
             * Intercooler dimensions and specifications
             */
            $table->double('intercooler_volume_l', 6, 2)->nullable();
            $table->double('intercooler_core_length_mm', 6, 2)->nullable();
            $table->double('intercooler_core_width_mm', 6, 2)->nullable();
            $table->double('intercooler_core_height_mm', 6, 2)->nullable();
            $table->double('intercooler_inlet_diameter_mm', 6, 2)->nullable();
            $table->double('intercooler_outlet_diameter_mm', 6, 2)->nullable();
            $table->double('intercooler_pressure_drop_bar', 4, 2)->nullable();
            /* ================================================ */

            /* ================================================ */
            /**
             * Boost characteristics
             */
            $table->double('max_boost_bar', 5, 2)->default(0);
            $table->double('min_boost_bar', 5, 2)->default(0);
            $table->double('peak_boost_rpm', 6, 0)->nullable();
            $table->double('boost_response_ms', 6, 2)->nullable();
            $table->double('boost_ramp_time_s', 5, 2)->nullable();
            /* ================================================ */

            /* ================================================ */
            /**
             * Temperature management
             */
            $table->integer('max_inlet_temp_celsius')->nullable();
            $table->integer('max_outlet_temp_celsius')->nullable();
            $table->double('intercooler_temp_drop_celsius', 4, 1)->nullable();
            $table->integer('coolant_temp_celsius')->nullable();
            $table->double('thermal_efficiency', 4, 2)->nullable();
            /* ================================================ */

            /* ================================================ */
            /**
             * Flow and pressure characteristics
             */
            $table->double('intake_lenght_cm', 6, 2);
            $table->double('intake_diameter_in', 5, 2);
            $table->double('air_flow_cfm', 8, 2)->nullable();
            ###
            $table->double('boost_pressure_bar', 4, 2);
            $table->integer('surge_margin_percent')->nullable();
            $table->double('compressor_efficiency_percent', 5, 2)->nullable();
            $table->double('turbine_efficiency_percent', 5, 2)->nullable();
            /* ================================================ */

            /* ================================================ */
            /**
             * Performance characteristics
             */
            $table->double('spool_time_ms', 6, 2)->nullable();
            $table->double('lag_ms', 6, 2)->nullable();
            /* ================================================ */

            /* ================================================ */
            /**
             * Reliability and durability metrics
             */
            $table->integer('max_rpm')->nullable();
            $table->integer('safe_rpm')->nullable();
            $table->double('weight_kg', 6, 2)->nullable();
            /* ================================================ */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forced_induction_system_specs');
    }
};
