<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleForcedInductionSpec extends Model
{
    protected $table = 'forced_induction_system_specs';

    protected $fillable = [
        'forced_induction_id',
        'turbo_config_pair',
        'turbine_diameter_mm', 
        'compressor_diameter_mm', 
        'turbo_max_rpm', 
        'supercharger_displacement_cc', 
        'pulley_diameter_mm', 
        'pulley_ratio', 
        'intercooler_volume_l', 
        'intercooler_core_length_mm', 
        'intercooler_core_width_mm', 
        'intercooler_core_height_mm', 
        'intercooler_inlet_diameter_mm', 
        'intercooler_outlet_diameter_mm', 
        'intercooler_pressure_drop_bar', 
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
        'boost_pressure_bar', 
        'surge_margin_percent', 
        'compressor_efficiency_percent', 
        'turbine_efficiency_percent', 
        'spool_time_ms', 
        'lag_ms', 
        'max_rpm', 
        'safe_rpm', 
        'weight_kg', 
    ];

    public function forcedInduction()
    {
        return $this->belongsTo(ForcedInduction::class, 'forced_induction_id');
    }
}
