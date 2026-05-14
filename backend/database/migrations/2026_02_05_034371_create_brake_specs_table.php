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
        Schema::create('brake_specs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brake_id')
                ->references('id')
                ->on('brakes')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('rotor_diameter_mm');
            $table->double('rotor_thickness_mm', 4, 1);
            $table->double('pad_thickness_mm', 4, 1);
            $table->string('pad_material');
            $table->double('max_force_kn', 4, 1);
            $table->double('friction_coefficient', 3, 2);
            $table->double('weight_kg', 5, 1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brake_specs');
    }
};
