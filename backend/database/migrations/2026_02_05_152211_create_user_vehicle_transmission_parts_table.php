<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_vehicle_transmissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_vehicle_id')
                ->references('id')
                ->on('user_vehicles')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('clutch_type');       // dry single, dry dual, wet, etc
            $table->integer('clutch_diameter_mm');
            $table->string('synchro_type');      // cone, brass, carbon, etc
            $table->string('material_case');     // aluminum, cast iron, steel
            $table->string('oil_type');
            $table->double('oil_capacity_l', 3, 1);

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicle_transmissions');
    }
};
