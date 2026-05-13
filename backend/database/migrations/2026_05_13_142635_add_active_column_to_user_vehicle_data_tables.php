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
        Schema::table('user_vehicle_specs', function (Blueprint $table) {
            $table->boolean('active')->default(0)->after('height');
        });

        Schema::table('user_vehicle_engines', function (Blueprint $table) {
            $table->boolean('active')->default(0)->after('fuel_type');
        });

        Schema::table('user_vehicle_engine_specs', function (Blueprint $table) {
            $table->boolean('active')->default(0)->after('torque_to_weight_ratio');
        });

        Schema::table('user_vehicle_engine_stages', function (Blueprint $table) {
            $table->boolean('active')->default(0)->after('expected_power');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_vehicle_engine_stages', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('user_vehicle_engine_specs', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('user_vehicle_engines', function (Blueprint $table) {
            $table->dropColumn('active');
        });

        Schema::table('user_vehicle_specs', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
};
