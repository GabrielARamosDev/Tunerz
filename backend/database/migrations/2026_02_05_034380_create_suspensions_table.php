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
        Schema::create('suspensions', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');
            $table->string('manufacturer');
            $table->string('type');              // independent, dependent, semi-independent

            $table->enum('configuration', [
                'macpherson', 
                'single wishbone',
                'double wishbone',
                'multi-link',
                'transverse',
            ]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suspensions');
    }
};
