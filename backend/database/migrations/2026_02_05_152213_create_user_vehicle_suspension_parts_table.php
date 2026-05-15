<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_vehicle_suspensions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_vehicle_id')
                ->references('id')
                ->on('user_vehicles')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('spring_type');       // coil, leaf, air, torsion bar
            $table->string('spring_material');
            $table->string('damper_type');       // telescopic, twin-tube, monotube
            $table->string('damper_material');   // aluminum, steel
            $table->string('wishbone_type');
            $table->double('stabilizer_diameter_mm', 4, 1);
            $table->boolean('has_abs')->default(true);

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicle_suspensions');
    }
};
