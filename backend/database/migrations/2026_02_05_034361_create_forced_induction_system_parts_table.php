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
        Schema::create('forced_induction_system_parts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('forced_induction_id')
                ->references('id')
                ->on('forced_induction_systems')
                ->constrained()
                ->cascadeOnDelete();

            /* ================================================ */
            // Turbocharger specific fields
            $table->enum('turbine_material', [
                'cast iron',
                'steel',
                'stainless steel',
                'titanium',
                'inconel',
            ])
                ->nullable()
                ->default(null);

            $table->enum('turbine_blade_type', [
                'single stage',
                'multi-stage',
                'variable geometry',
                'twin-scroll',
            ])
                ->nullable()
                ->default(null);

            $table->enum('compressor_material', [
                'aluminum alloy',
                'forged aluminum',
                'titanium',
                'composite',
            ])
                ->nullable()
                ->default(null);

            $table->enum('compressor_design', [
                'single stage',
                'multi-stage',
                'variable geometry',
                'roots',
                'twin-scroll',
            ])
                ->nullable()
                ->default(null);
            /* ================================================ */

            /* ================================================ */
            // Supercharger specific fields
            $table->enum('supercharger_type', [
                'roots',
                'twin-screw',
                'centrifugal',
            ])
                ->nullable()
                ->default(null);

            $table->enum('supercharger_drive', [
                'belt-driven',
                'gear-driven',
                'chain-driven',
                'electric',
            ])
                ->nullable()
                ->default(null);

            $table->enum('supercharger_material', [
                'aluminum',
                'steel',
                'composite',
                'cast iron',
            ])
                ->nullable()
                ->default(null);
            /* ================================================ */

            /* ================================================ */
            // Common induction components
            $table->enum('intercooler_type', [
                'air-to-air',
                'air-to-liquid',
                'water-to-air',
            ])
                ->nullable()
                ->default(null);

            $table->enum('intercooler_material', [
                'aluminum',
                'copper',
                'plastic',
                'composite',
            ])
                ->nullable()
                ->default(null);

            $table->enum('wastegate_type', [
                'internal',
                'external',
                'dual',
            ])
                ->nullable()
                ->default(null);

            $table->enum('wastegate_material', [
                'stainless steel',
                'steel',
                'titanium',
            ])
                ->nullable()
                ->default(null);

            $table->enum('blow_off_valve_type', [
                'atmospheric',
                'recirculating',
                'hybrid',
            ])
                ->nullable()
                ->default(null);

            $table->enum('blow_off_valve_material', [
                'aluminum',
                'steel',
                'composite',
            ])
                ->nullable()
                ->default(null);

            $table->enum('intake_manifold_material', [
                'cast iron',
                'aluminum',
                'composite',
                'carbon fiber',
            ])
                ->nullable()
                ->default(null);

            $table->enum('piping_material', [
                'aluminum',
                'steel',
                'silicone',
                'carbon fiber',
            ])
                ->nullable()
                ->default(null);
            /* ================================================ */

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forced_induction_system_parts');
    }
};
