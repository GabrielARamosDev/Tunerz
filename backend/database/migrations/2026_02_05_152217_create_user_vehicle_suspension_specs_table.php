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
        Schema::create('uv_suspension_specs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('suspension_id')
                ->references('id')
                ->on('suspensions')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_vehicle_id')
                ->references('id')
                ->on('user_vehicles')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('spring_constant_nm');
            $table->double('damping_ratio', 3, 2);
            $table->double('ride_height_mm', 5, 1);
            $table->double('ground_clearance_mm', 5, 1);
            $table->double('camber_angle_deg', 4, 1);
            $table->double('caster_angle_deg', 4, 1);
            $table->double('toe_in_mm', 4, 1);
            $table->double('stabilizer_diameter_mm', 4, 1);
            $table->double('weight_kg', 5, 1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vehicle_suspension_specs');
    }
};
