<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->string('brand');                 // Chevrolet
            $table->string('model');                 // Astra
            $table->year('model_year')->nullable();  // 2004
            $table->string('trim')->nullable();      // CD

            $table->enum('body_type', [
                'sedan',
                'hatchback',
                'suv',
                'pickup',
                'coupe',
                'convertible',
                'wagon',
                'van',
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

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
