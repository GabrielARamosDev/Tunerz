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
                /**/
                'hybrid',
                'electric',
            ]);

            /**
             * Garante que exista apenas 1 modelo de motor para cada 'carro de usuário', onde
             * cada um poderá ter mais de um motor associado, e cada motor com múltiplos 
             * 'specs' e 'stages', presumindo diferentes 'presets' configuráveis.
             */
            // $table->unique(['user_vehicle_id', 'code', 'manufacturer']);

            $table->timestamps(); 
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
