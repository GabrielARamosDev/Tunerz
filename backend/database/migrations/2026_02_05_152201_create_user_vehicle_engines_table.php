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
        Schema::create('user_vehicle_engines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_vehicle_id')
                ->references('id')
                ->on('user_vehicles')
                ->constrained()
                ->cascadeOnDelete();

            // garante que não haja dois motores "atuais"
            $table->unique(['user_vehicle_id']);
            
        });

        Schema::table('user_vehicles', function (Blueprint $table) {

            $table->unsignedBigInteger('user_vehicle_engine_id')
                ->nullable()
                ->default(null);

            $table->foreign('user_vehicle_engine_id')
                ->references('id')
                ->on('user_vehicle_engines')
                ->constrained()
                ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicle_engines');

        Schema::table('user_vehicles', function (Blueprint $table) {

            $table->dropForeign(['user_vehicle_engine_id']);
            $table->dropColumn('user_vehicle_engine_id');

        });
    }
};
