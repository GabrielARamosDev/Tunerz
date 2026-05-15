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
            $table->string('generation');    // 2ª

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

            $table->enum('camshaft_type', [
                'ohc',      // overhead camshaft
                'sohc',     // single overhead camshaft
                'dohc',     // double overhead camshaft
                'ohv',      // overhead valve
                'desmodromic',
            ]);

            $table->enum('fuel_system', [
                'spi',            // single-point fuel injection (tbi injection)
                'mpfi',           // multi-point fuel injection
                'mpfi (direct)', 
                'carbureted',
            ]);
            $table->enum('fuel_type', [
                'gasoline',
                'ethanol',
                'flex',     // gasoline + ethanol
                'vng',      // vehicular natural gas
                'diesel',
            ]);

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
