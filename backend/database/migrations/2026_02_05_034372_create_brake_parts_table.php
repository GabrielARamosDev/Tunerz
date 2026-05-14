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
        Schema::create('brake_parts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brake_id')
                ->references('id')
                ->on('brakes')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('rotor_type');        // ventilated, solid, drilled
            $table->string('rotor_material');    // cast iron, ceramic, carbon
            $table->string('caliper_type');      // single piston, dual piston, floating
            $table->string('caliper_material');  // aluminum, steel
            $table->string('pad_type');          // semi-metallic, ceramic, organic
            $table->string('pad_compound');
            $table->boolean('dust_shield')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brake_parts');
    }
};
