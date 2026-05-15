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
        Schema::create('wheel_specs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wheel_id')
                ->references('id')
                ->on('wheels')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('tire_width_mm')->default(165);
            $table->integer('tire_profile')->default(60);
            $table->integer('wheel_radius_in')->default(15);

            $table->double('expected_pressure_bar', 4, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wheel_specs');
    }
};
