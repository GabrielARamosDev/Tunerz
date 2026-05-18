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
                'flat',
                'flat (boxer)',
                'rotary',
            ]);

            $table->enum('rotation_direction', [
                'longitudinal',
                'transverse',
            ]);

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
