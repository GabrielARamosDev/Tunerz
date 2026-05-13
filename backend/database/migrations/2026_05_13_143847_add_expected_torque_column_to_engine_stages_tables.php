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
        Schema::table('engine_stages', function (Blueprint $table) {
            $table->decimal('boost_pressure', 10, 2)
                ->nullable(false)
                ->default(0)
                ->change();
            $table->decimal('expected_power', 10, 2)
                ->nullable(false)
                ->default(0)
                ->change();

            $table->decimal('expected_torque', 10, 2)->default(0.0)->after('expected_power');
        });

        Schema::table('user_vehicle_engine_stages', function (Blueprint $table) {
            $table->decimal('boost_pressure', 10, 2)
                ->nullable(false)
                ->default(0)
                ->change();
            $table->decimal('expected_power', 10, 2)
                ->nullable(false)
                ->default(0)
                ->change();

            $table->decimal('expected_torque', 10, 2)->default(0.0)->after('expected_power');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_vehicle_engine_stages', function (Blueprint $table) {
            $table->dropColumn('expected_torque');

            $table->decimal('boost_pressure', 10, 2)
                ->nullable(true)
                ->change();
            $table->decimal('expected_power', 10, 2)
                ->nullable(true)
                ->change();
        });

        Schema::table('engine_stages', function (Blueprint $table) {
            $table->dropColumn('expected_torque');

            $table->decimal('boost_pressure', 10, 2)
                ->nullable(true)
                ->change();
            $table->decimal('expected_power', 10, 2)
                ->nullable(true)
                ->change();
        });
    }
};
