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
        Schema::table('user_vehicle_engine_specs', function (Blueprint $table) {

            $table->integer('stock_power_rpm')->nullable()->after('stock_power_hp');
            $table->integer('stock_torque_rpm')->nullable()->after('stock_torque_nm');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_vehicle_engine_specs', function (Blueprint $table) {
            
            $table->dropColumn('stock_torque_rpm');
            $table->dropColumn('stock_power_rpm');

        });
    }
};
