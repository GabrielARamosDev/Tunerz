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

            /**
             * Garante que exista apenas 1 modelo de cada motor por marca.
             */
            $table->unique(['code', 'manufacturer']);

            $table->timestamps();
        });

        Schema::table('vehicles', function (Blueprint $table) {

            $table->unsignedBigInteger('engine_id')
                ->nullable()
                ->default(null)
                ->after('id');

            $table->foreign('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('engines');

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['engine_id']);
            $table->dropColumn('engine_id');
        });
    }
};
