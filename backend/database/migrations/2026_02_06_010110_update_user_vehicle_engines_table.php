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
        Schema::table('user_vehicle_engine', function (Blueprint $table) {
        
            $table->string('code');          // X20XEV
            $table->string('manufacturer');  // GM
            $table->integer('displacement'); // 1998 (2.0)
            $table->integer('valve_count');  // 8v

            $table->enum('propulsion', [
                'combustion',
                'hybrid',
                'electric',
            ]);

            $table->enum('fuel_type', [
                'gasoline',
                'ethanol',
                'flex',
                'vng',      // vehicular natural gas
                'diesel',
                /**/
                'hybrid',
                'electric',
            ]);

            $table->unique(['code', 'manufacturer']);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_vehicle_engine', function (Blueprint $table) {

            $table->dropColumn('updated_at');
            $table->dropColumn('created_at');
            
            $table->dropUnique(['code', 'manufacturer']);

            $table->dropColumn('fuel_type');
            $table->dropColumn('propulsion');
            $table->dropColumn('valve_count');
            $table->dropColumn('displacement');
            $table->dropColumn('manufacturer');
            $table->dropColumn('code');


        });
    }
};
