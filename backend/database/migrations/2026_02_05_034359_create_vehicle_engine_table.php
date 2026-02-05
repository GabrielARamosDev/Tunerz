<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('vehicle_engine', function (Blueprint $table) {

            $table->foreignId('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained()
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_engine');
    }
};
