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
             * Stock values for comparison purpose
             */
            $table->integer('stock_power_hp')->nullable();
            $table->integer('stock_power_rpm')->nullable();
            $table->integer('stock_torque_nm')->nullable();
            $table->integer('stock_torque_rpm')->nullable();

            $table->double('stock_power_to_weight_ratio', 8, 4)->nullable();
            $table->double('stock_torque_to_weight_ratio', 8, 4)->nullable();
            /* ================================================ */

            /* ================================================ */
            /**
             * Modified values with forced induction
             */
            $table->integer('modified_power_hp')->nullable();
            $table->integer('modified_power_rpm')->nullable();
            $table->integer('modified_torque_nm')->nullable();
            $table->integer('modified_torque_rpm')->nullable();

            $table->double('modified_power_to_weight_ratio', 8, 4)->nullable();
            $table->double('modified_torque_to_weight_ratio', 8, 4)->nullable();
            /* ================================================ */

            /* ================================================ */
            /**
             * Boost characteristics
             */
            $table->double('max_boost_bar', 5, 2);
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
            $table->double('air_flow_cfm', 8, 2)->nullable();
            $table->double('boost_pressure_bar', 4, 2);
            $table->integer('surge_margin_percent')->nullable();
            $table->double('compressor_efficiency_percent', 5, 2)->nullable();
            $table->double('turbine_efficiency_percent', 5, 2)->nullable();
            /* ================================================ */

            /* ================================================ */
            /**
             * Performance characteristics
             */
            $table->double('power_gain_hp', 6, 2)->nullable();
            $table->double('torque_gain_nm', 6, 2)->nullable();
            $table->double('power_gain_percent', 5, 2)->nullable();
            $table->double('torque_gain_percent', 5, 2)->nullable();
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
            $table->integer('expected_life_hours')->nullable();
            $table->boolean('requires_high_octane')->default(false);
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
