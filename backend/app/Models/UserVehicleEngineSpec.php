<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEngineSpec extends Model
{
    protected $table = 'user_vehicle_engine_specs';

    protected $fillable = [
        'user_vehicle_engine_id', 
        'place', 
        'orientation',
        'cylinder_configuration',
        'cylinders_count',
        'valves_per_cylinder',
        'valve_lash_type', 
        'valve_follower_type', 
        'valve_actuation_type', 
        'compression_ratio',
        'aspiration',
        'fuel_system',
        'camshaft_type',
        'command_drive',
        'bore_mm',
        'stroke_mm',
        'stock_power_hp',
        'stock_power_rpm',
        'stock_torque_nm',
        'stock_torque_rpm',
        'specific_power_hp_per_liter',
        'specific_torque_nm_per_liter',
        'power_to_weight_ratio',
        'torque_to_weight_ratio',
    ];

    public function userVehicleEngine() {
        return $this->belongsTo(UserVehicleEngine::class);
    }
}
