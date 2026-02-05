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
        Schema::create('engine_stages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('engine_id')
                ->references('id')
                ->on('engines')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('modification_type_id')
                ->references('id')
                ->on('modification_types')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->decimal('boost_pressure', 10, 2)->nullable();
            $table->decimal('expected_power', 10, 2)->nullable();
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engine_stages');
    }
};
