<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_vehicle_engines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_vehicle_id')
                ->references('id')
                ->on('user_vehicles')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('piston_head_type', [
                'flat',
                'domed',
                'dish',
                'spherical',
            ]);
            $table->enum('piston_head_material', [
                'aluminum alloy',
                'forged aluminum',
                'steel',
                'titanium',
            ]);
            $table->enum('piston_conrod_type', [
                'I-beam',
                'H-beam',
                'forged',
                'billet',
            ]);
            $table->enum('piston_conrod_material', [
                'steel',
                'forged steel',
                'titanium',
                'aluminum alloy',
            ]);
            $table->double('piston_bore_mm', 5, 2);
            $table->double('piston_stroke_mm', 5, 2);

            $table->double('compression_ratio', 4, 2);
            $table->integer('displacement_cc');

            $table->enum('camshaft_type', [
                'roller',
                'flat tappet',
                'lobe',
                'billet',
            ]);
            $table->enum('camshaft_material', [
                'cast iron',
                'steel',
                'forged steel',
                'billet steel',
            ]);

            $table->enum('valve_type', [
                'poppet',
                'rotary',
                'mushroom',
            ]);
            $table->enum('valve_material', [
                'stainless steel',
                'titanium',
                'alloy steel',
            ]);
            
            $table->double('intake_valve_diameter_mm', 5, 2);
            $table->integer('intake_valve_seat_angle');
            $table->double('exhaust_valve_diameter_mm', 5, 2);
            $table->integer('exhaust_valve_seat_angle');

            $table->enum('valve_control_type', [
                'mechanical',
                'hydraulic',
                'electronic',
            ]);
            $table->enum('valve_control_material', [
                'steel',
                'titanium',
                'aluminum',
            ]);

            $table->boolean('has_VVT')->default(false);
            $table->boolean('has_VVL')->default(false);

            $table->enum('aspiration', [
                'NA',                              // naturally aspirated
                'turbocharged',                    // single turbo
                'twin_turbocharged (sequential)',  // sequential, parallel, etc
                'twin_turbocharged (parallel)',    // sequential, parallel, etc
                'twin_turbocharged (compound)',    // sequential, parallel, etc
                'supercharger',                    // roots, twin-screw, or centrifugal
                'twin_charged',                    // turbo + supercharger
                'electric_turbo',                  // e-turbo
                'electric_supercharger',           // e-supercharger
            ]);

            $table->double('max_safe_boost_bar');

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicle_engines');
    }
};
