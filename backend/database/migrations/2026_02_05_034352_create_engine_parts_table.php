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

            $table->foreignId('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('piston_head_type', [

            ]);
            $table->enum('piston_head_material', [

            ]);
            $table->enum('piston_conrod_type', [

            ]);
            $table->enum('piston_conrod_material', [

            ]);
            $table->double('piston_bore_mm', 2, 2);
            $table->double('piston_stroke_mm', 2, 2);

            $table->enum('camshaft_type', [

            ]);
            $table->enum('camshaft_material', [

            ]);

            $table->enum('valve_type', [

            ]);
            $table->enum('valve_material', [

            ]);
            
            $table->double('intake_valve_diameter_mm', 2, 2);
            $table->integer('intake_valve_seat_angle');
            $table->double('exhaust_valve_diameter_mm', 2, 2);
            $table->integer('exhaust_valve_seat_angle');

            $table->enum('valve_control_type', [

            ]);
            $table->enum('valve_control_material', [

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
        Schema::dropIfExists('engine_parts');
    }
};
