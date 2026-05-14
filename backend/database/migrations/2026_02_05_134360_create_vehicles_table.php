<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('engine_id')
                ->nullable()
                ->default(null);

            $table->foreign('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained();

            $table->string('manufacturer');          // Chevrolet
            $table->string('model');                 // Astra
            $table->string('trim')->nullable();      // CD
            $table->integer('year')->nullable();     // 2004

            $table->enum('body_type', [
                'sedan',
                'hothatch',
                'hatchback',
                'suv',
                'pickup',
                'coupe',
                'convertible',
                'wagon',
                'van',
                'targa',
            ]);

            $table->string('image_url')->nullable();

            /**
             * Garante que exista apenas 1 modelo de cada carro por marca, 
             * considerando as versões, carroceria e ano.
             */
            $table->unique(['manufacturer', 'model', 'trim', 'year', 'body_type']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
