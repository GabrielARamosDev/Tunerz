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

            $table->enum('aspiration', [
                'NA',                              // naturally aspirated
                'turbocharged',                    // single turbo
                'twin_turbocharged (sequential)',  // sequential, parallel, etc
                'twin_turbocharged (parallel)',    // sequential, parallel, etc
                'twin_turbocharged (compound)',    // sequential, parallel, etc
                'supercharger',                    // roots, twin-screw, or centrifugal
                'twin_charged',                    // turbo + supercharger
                'electric_turbo',                  // e-turbo
                'electric_supercharger',           // e-supercharger
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
                'aluminum billet', 
                'forged aluminum', 
                'forged aluminum billet', 
                'magnesium', 
                'steel' ,
                'forged steel' ,
                'forged steel billet' ,
            ]);
            $table->enum('head_material', [
                'cast iron', 
                'aluminum billet', 
                'forged aluminum', 
                'forged aluminum billet', 
                'magnesium', 
                'steel' ,
                'forged steel' ,
                'forged steel billet' ,
            ]);

            $table->double('length_mm');
            $table->double('width_mm');
            $table->double('height_mm');

            $table->double('weight_kg');

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
