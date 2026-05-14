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
        Schema::create('user_vehicles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->references('id')
                ->on('users')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('manufacturer');            // Chevrolet
            $table->string('model');                   // Astra
            $table->string('trim')->nullable();        // trim/version: CD
            $table->integer('year')->nullable();       // 2004
            $table->integer('generation')->nullable(); // 3ª

            $table->unsignedBigInteger('engine_id')
                ->nullable()
                ->default(null);
            $table->foreign('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained();
                
            $table->unsignedBigInteger('transmission_id')
                ->nullable()
                ->default(null);
            $table->foreign('transmission_id')
                ->references('id')
                ->on('transmissions')
                ->constrained();

            $table->unsignedBigInteger('front_suspension_id')
                ->nullable()
                ->default(null);
            $table->foreign('front_suspension_id')
                ->references('id')
                ->on('front_suspensions')
                ->constrained();
            $table->unsignedBigInteger('rear_suspension_id')
                ->nullable()
                ->default(null);
            $table->foreign('rear_suspension_id')
                ->references('id')
                ->on('rear_suspensions')
                ->constrained();

            $table->unsignedBigInteger('front_brake_id')
                ->nullable()
                ->default(null);
            $table->foreign('front_brake_id')
                ->references('id')
                ->on('front_brakes')
                ->constrained();
            $table->unsignedBigInteger('rear_brake_id')
                ->nullable()
                ->default(null);
            $table->foreign('rear_brake_id')
                ->references('id')
                ->on('rear_brakes')
                ->constrained();

            $table->string('image_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicles');
    }
};
