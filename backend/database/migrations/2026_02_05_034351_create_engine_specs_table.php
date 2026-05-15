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
        Schema::create('engine_specs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('stock_power_hp')->nullable();
            $table->integer('stock_power_rpm')->nullable();
            $table->integer('stock_torque_nm')->nullable();
            $table->integer('stock_torque_rpm')->nullable();

            $table->double('stock_power_to_weight_ratio', 8, 4)->nullable();
            $table->double('stock_torque_to_weight_ratio', 8, 4)->nullable();

            $table->integer('stock_redline_rpm');
            $table->integer('stock_idle_rpm');

            $table->double('air_flow_cfm');
            $table->double('fuel_pressure_bar');
            $table->double('thermal_efficiency');

            $table->double('oil_capacity_l');
            $table->double('coolant_capacity_l');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engine_specs');
    }
};
