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
        Schema::create('uv_suspension_parts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('suspension_id')
                ->references('id')
                ->on('suspensions')
                ->constrained();

            $table->foreignId('user_vehicle_id')
                ->references('id')
                ->on('user_vehicles')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('spring_type', [
                'coil',
                'leaf',
                'air',
                'torsion bar',
            ]);
            $table->enum('spring_material', [
                'steel',
                'titanium',
                'composite',
            ]);

            $table->enum('damper_type', [
                'telescopic',
                'twin-tube',
                'monotube',
            ]);
            $table->enum('damper_material', [
                'aluminum',
                'steel',
            ]);

            $table->boolean('has_abs')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicle_suspension_parts');
    }
};
