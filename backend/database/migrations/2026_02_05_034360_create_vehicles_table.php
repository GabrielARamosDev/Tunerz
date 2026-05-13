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

            $table->enum('drivetrain', [
                'fwd', // front-wheel drive
                'rwd', // rear-wheel drive
                'awd', // all-wheel drive
                '4wd', // four-wheel drive
            ]);

            $table->double('price', 10, 2)->nullable();
            $table->enum('price_currency', ['USD', 'EUR', 'BRL'])->nullable();

            $table->double('weight', 10, 2)->nullable(); // kg
            $table->enum('weight_unit', ['kg', 'lb'])->nullable();

            $table->double('width', 10, 2)->nullable();  // mm
            $table->double('length', 10, 2)->nullable(); // mm

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
