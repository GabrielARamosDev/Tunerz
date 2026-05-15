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
        Schema::create('transmission_parts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('transmission_id')
                ->references('id')
                ->on('transmissions')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('clutch_type', [
                'dry single',
                'dry dual',
                'wet',
                'multi-plate',
            ]);
            $table->enum('synchro_type', [
                'cone',
                'brass',
                'carbon',
                'baulk',
            ]);
            $table->enum('material_case', [
                'aluminum',
                'cast iron',
                'steel',
            ]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transmission_parts');
    }
};
