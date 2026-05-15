<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('engines', function (Blueprint $table) {
            $table->id();

            $table->string('name');          // Família II
            $table->string('code');          // X20XEV
            $table->string('manufacturer');  // GM
            $table->integer('generation')->nullable();

            $table->enum('architecture', [
                'inline',
                'v (15º)',
                'v (30º)',
                'v (60º)',
                'flat (180º)',
                'flat (boxer)',
                'rotary',
            ]);

            $table->enum('rotation_direction', [
                'longitudinal',
                'transverse',
            ]);

            $table->integer('cylinders_count');
            $table->integer('valve_count');

            $table->enum('camshaft_config', [
                'ohc',      // overhead camshaft
                'sohc',     // single overhead camshaft
                'dohc',     // double overhead camshaft
                'ohv',      // overhead valve
                'desmodromic',
            ]);

            $table->enum('fuel_type', [
                'gasoline',
                'ethanol',
                'flex',     // gasoline + ethanol
                'vng',      // vehicular natural gas
                'diesel',
            ]);
            $table->enum('fuel_system', [
                'spfi', // single-point fuel injection (tbi injection)
                'mpfi', // multi-point fuel injection
                'dfi',  // direct fuel injection
                'carburator (vertical)',
                'carburator (horizontal)',
            ]);

            /* ================================================ */
            /**
             * Only aplicable if: fuel_system = 'some type of carburator'
             */
            $table->enum('carburator_system', [ 
                'fixed-venturi', 
                'variable-venturi', 
            ])
                ->nullable()
                ->default(null);
            $table->integer('carburator_barrel_count') 
                ->nullable()
                ->default(0);
            /* ================================================ */

            $table->enum('block_material', [
                'cast iron',
                'aluminum alloy',
                'forged aluminum',
                'magnesium',
                'steel',
                'forged steel',
                'titanium',
            ]);
            $table->enum('head_material', [
                'cast iron',
                'aluminum alloy',
                'forged aluminum',
                'magnesium',
                'steel',
                'forged steel',
                'titanium',
            ]);

            $table->double('length_mm')->default(0);
            $table->double('width_mm')->default(0);
            $table->double('height_mm')->default(0);

            $table->double('weight_kg')->default(0);

            /**
             * Garante que exista apenas 1 modelo de cada motor por marca.
             */
            $table->unique(['code', 'manufacturer']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('engines');
    }
};
