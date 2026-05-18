<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForcedInductionSpec extends Model
{
    protected $table = 'forced_induction_system_specs';

    protected $fillable = [
        'forced_induction_id',
        'stock_power_hp',
        'stock_power_rpm',
        'stock_torque_nm',
        'stock_torque_rpm',
        'stock_power_to_weight_ratio',
        'stock_torque_to_weight_ratio',
        'modified_power_hp',
        'modified_power_rpm',
        'modified_torque_nm',
        'modified_torque_rpm',
        'modified_power_to_weight_ratio',
        'modified_torque_to_weight_ratio',
        'max_boost_bar',
        'min_boost_bar',
        'peak_boost_rpm',
        'boost_response_ms',
        'boost_ramp_time_s',
        'max_inlet_temp_celsius',
        'max_outlet_temp_celsius',
        'intercooler_temp_drop_celsius',
        'coolant_temp_celsius',
        'thermal_efficiency',
        'air_flow_cfm',
        'boost_pressure_bar',
        'surge_margin_percent',
        'compressor_efficiency_percent',
        'turbine_efficiency_percent',
        'power_gain_hp',
        'torque_gain_nm',
        'power_gain_percent',
        'torque_gain_percent',
        'spool_time_ms',
        'lag_ms',
        'max_rpm',
        'safe_rpm',
        'weight_kg',
        'expected_life_hours',
        'requires_high_octane',
    ];

    public function forcedInduction()
    {
        return $this->belongsTo(ForcedInduction::class, 'forced_induction_id');
    }
}
