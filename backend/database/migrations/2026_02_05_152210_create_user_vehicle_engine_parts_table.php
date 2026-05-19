<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uv_engine_parts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_vehicle_id')
                ->references('id')
                ->on('user_vehicles')
                ->constrained()
                ->cascadeOnDelete();

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

            $table->enum('piston_head_type', [
                'flat',
                'domed',
                'dish',
                'spherical',
            ]);
            $table->enum('piston_head_material', [
                'aluminum alloy',
                'forged aluminum',
                'steel',
                'titanium',
            ]);
            $table->enum('piston_conrod_type', [
                'I-beam',
                'H-beam',
                'forged',
                'billet',
            ]);
            $table->enum('piston_conrod_material', [
                'steel',
                'forged steel',
                'titanium',
                'aluminum alloy',
            ]);

            $table->enum('camshaft_material', [
                'cast iron',
                'steel',
                'forged steel',
                'billet steel',
                'aluminum',
                'titanium',
            ]);
            $table->enum('camshaft_type', [
                'roller',
                'flat tappet',
                'lobe',
                'billet',
            ]);
            $table->enum('camshaft_config', [
                'ohc',      // overhead camshaft
                'sohc',     // single overhead camshaft
                'dohc',     // double overhead camshaft
                'ohv',      // overhead valve
            ]);
            $table->enum('camshaft_actuation', [
                'mechanical',
                'hydraulic',
                'electronic',
                'desmodromic',
            ]);

            $table->enum('valve_material', [
                'stainless steel',
                'titanium',
                'alloy steel',
            ]);
            $table->enum('valve_type', [
                'poppet',
                'rotary',
                'mushroom',
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
            // Only aplicable if: fuel_system = 'carburator'
            $table->enum('carburator_system', [ 
                'fixed-venturi', 
                'variable-venturi', 
            ])
                ->nullable()
                ->default(null);
            /* ================================================ */

            $table->enum('intake_manifold_material', [
                'thermoplastics', 
                'cast iron',
                'aluminum',
                'composite',
                'carbon fiber',
            ]);
            $table->enum('intake_type', [
                'stock',     // Factory-installed systems designed for air filtration and noise reduction.
                'short ram', // A shorter, direct intake path often placed closer to the engine for better throttle response.
                'ram-air',   // Positioned at the front of the vehicle to utilize forward momentum for forcing higher-density air into the engine.
                'cold-air',  // Air filter outside the engine compartment to ingest cooler, denser air,
            ]);
            $table->enum('intake_piping_material', [
                'thermoplastics', 
                'aluminum',
                'steel',
                'silicone',
                'carbon fiber',
            ]);

            $table->enum('induction_system', [
                'NA',                  // naturally aspirated
                'single-turbocharged',             
                'twin-turbocharged',   // sequential, parallel, compound
                'supercharged',        // roots, twin-screw, centrifugal
                'twin-charged',        // turbocharger + supercharger
            ]);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicle_engine_parts');
    }
};
