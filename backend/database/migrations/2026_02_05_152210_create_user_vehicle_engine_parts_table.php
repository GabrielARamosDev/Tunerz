<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_vehicle_engines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_vehicle_id')
                ->references('id')
                ->on('user_vehicles')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('code');          // X20XEV
            $table->string('manufacturer');  // GM
            $table->integer('displacement'); // 1998 (2.0)
            $table->integer('valve_count');  // 8v

            $table->enum('propulsion', [
                'combustion',
                'hybrid',
                'electric',
            ]);

            $table->enum('fuel_type', [
                'gasoline',
                'ethanol',
                'flex',
                'vng',      // vehicular natural gas
                'diesel',
            ]);

            $table->boolean('active')->default(0);

            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicle_engines');
    }
};
