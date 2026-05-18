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
        Schema::create('forced_induction_systems', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');
            $table->string('manufacturer');

            $table->enum('type', [
                'single_turbocharged',             
                'twin_turbocharged',               // sequential, parallel, compound
                'supercharged',                    // roots, twin-screw, centrifugal
                'twin_charged',                    // turbocharger + supercharger
            ]);

            /* ================================================ */
            //Only aplicable if: aspiration = 'twin_turbocharged'
            $table->enum('twin_turbo_config', [
                'sequential', 
                'parallel', 
                'compound', 
            ])
                ->nullable()
                ->default(null);

            $table->enum('twin_turbo_count', [ 2, 4 ])
                ->nullable()
                ->default(null);
            /* ================================================ */

            /* ================================================ */
            //Only aplicable if: aspiration = 'supercharged'
            $table->enum('supercharger_config', [
                'roots', 
                'twin-screw', 
                'centrifugal', 
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
        Schema::dropIfExists('forced_induction_systems');
    }
};
