<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE engine_specs
            MODIFY valve_tappet ENUM(
                'hydraulic',
                'solid',
                'roller',
                'flat',
                'mushroom',
                'bucket',
                'desmodromic'
            ) NOT NULL
        ");

        Schema::table('engine_specs', function (Blueprint $table) {
        
            $table->integer('stock_power_rpm')->nullable()->after('stock_power_hp');
            $table->integer('stock_torque_rpm')->nullable()->after('stock_torque_nm');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('engine_specs', function (Blueprint $table) {
        
            $table->dropColumn('stock_torque_rpm');
            $table->dropColumn('stock_power_rpm');

        });

        DB::statement("
            ALTER TABLE engine_specs
            MODIFY valve_tappet ENUM(
                'hydraulic_lifter',
                'solid_lifter',
                'finger_follower',
                'desmodromic'
            ) NOT NULL
        ");
    }
};
