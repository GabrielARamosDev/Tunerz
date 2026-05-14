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
        Schema::create('engine_parts', function (Blueprint $table) {
            $table->id();

            $table->enum('piston_head_type', [

            ]);
            $table->enum('piston_head_material', [

            ]);
            $table->enum('piston_conrod_type', [

            ]);
            $table->enum('piston_conrod_material', [

            ]);
            $table->enum('piston_bore_mm', [

            ]);
            $table->enum('piston_stroke_mm', [

            ]);

            $table->enum('camshaft_type', [

            ]);
            $table->enum('camshaft_material', [

            ]);

            $table->enum('valve_control_type', [

            ]);
            $table->enum('valve_control_material', [

            ]);

            $table->enum('valve_type', [

            ]);
            $table->enum('valve_material', [

            ]);
            
            $table->enum('intake_valve_diameter_mm', [

            ]);
            $table->enum('intake_valve_seat_angle', [

            ]);
            $table->enum('exhaust_valve_diameter_mm', [

            ]);
            $table->enum('exhaust_valve_seat_angle', [

            ]);

            $table->boolean('has_VVT');
            $table->boolean('has_VVL');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engine_parts');
    }
};
