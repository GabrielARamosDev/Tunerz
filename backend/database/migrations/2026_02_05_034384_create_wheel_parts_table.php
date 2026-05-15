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
        Schema::create('wheel_parts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wheel_id')
                ->references('id')
                ->on('wheels')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('tire_material', [
                'rubber (natural)',
                'rubber (synthetic)',
            ])->nullable();

            $table->enum('wheel_material', [
                'steel',
                'aluminum alloy',
                'forged aluminum',
                'titanium',
                'carbon fiber',
                'magnesium',
            ])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wheel_parts');
    }
};
