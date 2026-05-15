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
        Schema::create('transmission_specs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('transmission_id')
                ->references('id')
                ->on('transmissions')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('gears_count');
            $table->double('gear_ratio_1', 5, 2);
            $table->double('gear_ratio_2', 5, 2);
            $table->double('gear_ratio_3', 5, 2);
            $table->double('gear_ratio_4', 5, 2);
            $table->double('gear_ratio_5', 5, 2)->nullable();
            $table->double('gear_ratio_6', 5, 2)->nullable();
            $table->double('gear_ratio_7', 5, 2)->nullable();

            $table->double('final_drive_ratio', 5, 2);

            $table->integer('clutch_diameter_mm');
            $table->integer('max_torque_nm');
            
            $table->double('weight_kg', 5, 1);

            $table->double('oil_capacity_l', 3, 1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transmission_specs');
    }
};
