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
            
            $table->foreignId('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('piston_head_type', [
                'flat',
                'domed',
                'dish',
                'spherical',
                'custom',
            ]);
            $table->enum('piston_head_material', [
                'aluminum alloy',
                'forged aluminum',
                'steel',
                'titanium',
                'custom',
            ]);
            $table->enum('piston_conrod_type', [
                'I-beam',
                'H-beam',
                'forged',
                'billet',
                'custom',
            ]);
            $table->enum('piston_conrod_material', [
                'steel',
                'forged steel',
                'titanium',
                'aluminum alloy',
                'custom',
            ]);
            $table->double('piston_bore_mm', 2, 2);
            $table->double('piston_stroke_mm', 2, 2);

            $table->enum('camshaft_type', [
                'roller',
                'flat tappet',
                'lobe',
                'billet',
                'custom',
            ]);
            $table->enum('camshaft_material', [
                'cast iron',
                'steel',
                'forged steel',
                'billet steel',
                'custom',
            ]);

            $table->enum('valve_type', [
                'poppet',
                'rotary',
                'mushroom',
                'custom',
            ]);
            $table->enum('valve_material', [
                'stainless steel',
                'titanium',
                'alloy steel',
                'custom',
            ]);
            
            $table->double('intake_valve_diameter_mm', 2, 2);
            $table->integer('intake_valve_seat_angle');
            $table->double('exhaust_valve_diameter_mm', 2, 2);
            $table->integer('exhaust_valve_seat_angle');

            $table->enum('valve_control_type', [
                'mechanical',
                'hydraulic',
                'electronic',
                'custom',
            ]);
            $table->enum('valve_control_material', [
                'steel',
                'titanium',
                'aluminum',
                'custom',
            ]);

            $table->boolean('has_VVT')->default(false);
            $table->boolean('has_VVL')->default(false);

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
