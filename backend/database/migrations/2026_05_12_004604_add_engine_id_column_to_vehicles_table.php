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
        // Schema::dropIfExists('vehicle_engine');

        Schema::table('vehicles', function (Blueprint $table) {

            $table->unsignedBigInteger('engine_id')
                ->nullable()
                ->after('trim');

            $table->foreign('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            
            $table->dropForeign(['vehicles_engine_id_foreign']);
            $table->dropColumn('engine_id');

        });
        
        Schema::create('vehicle_engine', function (Blueprint $table) {

            $table->foreignId('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained()
                ->cascadeOnDelete();

        });
    }
};
