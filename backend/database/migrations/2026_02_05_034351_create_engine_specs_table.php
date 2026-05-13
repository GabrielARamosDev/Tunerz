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

            $table->enum('place', [
                'front',
                'mid',
                'rear',
            ]);
            $table->enum('orientation', [
                'longitudinal',
                'transverse',
            ]);

            $table->enum('cylinder_configuration', [
                'inline',
                'v',
                'flat',
                'rotary',
                'electric',
            ]);
            $table->integer('cylinders_count');

            $table->integer('valves_per_cylinder');
            $table->enum('valve_lash_type', [
                'hydraulic',
                'solid'
            ]);
            $table->enum('valve_follower_type', [
                'roller', 
                'flat_tappet', 
                'bucket', 
                'finger_follower', 
                'mushroom'
            ]);
            $table->enum('valve_actuation_type', [
                'spring', 
                'desmodromic'
            ]);

            $table->double('compression_ratio', 4, 2);

            $table->enum('aspiration', [
                'na',                    // naturally aspirated
                'turbocharged',          // single turbo
                'twin_turbocharged',     // sequential, parallel, etc
                'supercharger',          // roots, twin-screw, or centrifugal
                'twin_charged',          // turbo + supercharger
                'electric_turbo',        // e-turbo
                'electric_supercharger', // e-supercharger
            ]);

            $table->enum('fuel_system', [
                'mpfi',      // multi-point fuel injection
                'spi',       // single-point fuel injection / throttle body injection
                'carbureted',
                'direct_injection',
                'dual_injection', // direct + port injection
                'electric',
            ]);

            $table->enum('camshaft_type', [
                'ohc',      // overhead camshaft
                'sohc',     // single overhead camshaft
                'dohc',     // double overhead camshaft
                'ohv',      // overhead valve
                'desmodromic',
            ]);
            $table->enum('command_drive', [
                'belt',
                'chain',
                'gears',
            ]);

            $table->double('bore_mm', 5, 2);
            $table->double('stroke_mm', 5, 2);

            $table->integer('stock_power_hp')->nullable();
            $table->integer('stock_power_rpm')->nullable();
            $table->integer('stock_torque_nm')->nullable();
            $table->integer('stock_torque_rpm')->nullable();

            $table->double('specific_power_hp_per_liter', 6, 2)->nullable();
            $table->double('specific_torque_nm_per_liter', 6, 2)->nullable();

            $table->double('power_to_weight_ratio', 8, 4)->nullable();
            $table->double('torque_to_weight_ratio', 8, 4)->nullable();

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
