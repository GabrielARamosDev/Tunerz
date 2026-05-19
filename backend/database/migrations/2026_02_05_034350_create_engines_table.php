<?php

use App\Constants\Workshop;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('engines', function (Blueprint $table) {
            $table->id();

            $table->string('name');          // Família II
            $table->string('code');          // X20XEV
            $table->string('manufacturer');  // GM
            $table->integer('generation')->nullable();

            $table->enum('architecture', Workshop::ENGINE['architecture']);

            $table->enum('rotation_direction', Workshop::ENGINE['rotation_direction']);

            /**
             * Garante que exista apenas 1 modelo de cada motor por marca.
             */
            $table->unique(['code', 'manufacturer']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('engines');
    }
};
