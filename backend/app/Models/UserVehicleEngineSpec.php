<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEngineSpec extends Model
{
    protected $table = 'uv_engine_specs';

    protected $fillable = [
        'engine_id',
        'user_vehicle_id',
        ###
        'power_hp',
        'power_rpm',
        'torque_nm',
        'torque_rpm',
        'power_to_weight_ratio',
        'torque_to_weight_ratio',
        'idle_rpm',
        'redline_rpm',
        ###
        'cylinders_count',
        'piston_bore_mm',
        'piston_stroke_mm',
        'displacement_cc',
        'compression_ratio',
        'valve_count',
        ###
        'intake_valve_diameter_mm',
        'intake_valve_seat_angle',
        'exhaust_valve_diameter_mm',
        'exhaust_valve_seat_angle',
        ###
        'carburator_barrel_count',
        ###
        'fuel_injection_time_ms', 
        'fuel_flowrate_cc_min', 
        'fuel_pressure_bar',
        'air_fuel_ratio', 
        ###
        'intake_lenght_cm', 
        'intake_diameter_in', 
        'air_flow_cfm', 
        ###
        'thermal_efficiency',
        'coolant_capacity_l',
        'oil_capacity_l',
        ###
        'length_mm',
        'width_mm',
        'height_mm',
        'weight_kg',
    ];

    public function engine() {
        return $this->belongsTo(Engine::class);
    }
}
