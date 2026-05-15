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

            $table->enum('rotor_type', [
                'ventilated',
                'solid',
                'drilled',
            ]);
            $table->enum('rotor_material', [
                'cast iron',
                'ceramic',
                'carbon',
            ]);
            $table->enum('caliper_type', [
                'single piston',
                'dual piston',
                'floating',
                'fixed',
            ]);
            $table->enum('caliper_material', [
                'aluminum',
                'steel',
            ]);
            $table->enum('pad_type', [
                'semi-metallic',
                'ceramic',
                'organic',
            ]);
            $table->enum('pad_material', [
                'semi-metallic',
                'ceramic',
                'organic',
            ]);
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
