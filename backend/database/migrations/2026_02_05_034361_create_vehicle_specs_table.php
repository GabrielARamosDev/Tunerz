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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'drivetrain',
                'price',
                'price_currency',
                'weight',
                'weight_unit',
                'width',
                'length',
            ]);
        });

        Schema::create('vehicle_specs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('generation', 16)->nullable();
            $table->string('platform', 32)->nullable();
            $table->string('series', 16)->nullable();

            $table->enum('drivetrain', [
                'fwd', // front-wheel drive
                'rwd', // rear-wheel drive
                'awd', // all-wheel drive
                '4wd', // four-wheel drive
            ]);

            $table->enum('transmission', [
                'manual',
                'semi_automatic',
                'automatic',
                'cvt',
                'dual_clutch',
            ]);

            $table->double('price', 10, 2)->nullable();
            $table->enum('price_currency', ['USD', 'EUR', 'BRL'])->nullable();

            $table->double('weight', 10, 2)->nullable(); // kg
            $table->enum('weight_unit', ['kg', 'lb'])->nullable();

            $table->double('width', 10, 2)->nullable();  // mm
            $table->double('length', 10, 2)->nullable(); // mm
            $table->double('height', 10, 2)->nullable(); // mm

            $table->unique('vehicle_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_specs');

        Schema::table('vehicles', function (Blueprint $table) {

            $table->double('length', 10, 2)->nullable(); // mm
            $table->double('width', 10, 2)->nullable();  // mm

            $table->enum('weight_unit', ['kg', 'lb'])->nullable();
            $table->double('weight', 10, 2)->nullable(); // kg

            $table->enum('price_currency', ['USD', 'EUR', 'BRL'])->nullable();
            $table->double('price', 10, 2)->nullable();

            $table->enum('drivetrain', [
                'fwd', // front-wheel drive
                'rwd', // rear-wheel drive
                'awd', // all-wheel drive
                '4wd', // four-wheel drive
            ]);

        });
    }
};
