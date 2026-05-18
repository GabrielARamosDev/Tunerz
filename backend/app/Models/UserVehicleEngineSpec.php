<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEngineSpec extends Model
{
    protected $fillable = [
        'engine_id',
        ###
        'stock_power_hp',
        'stock_power_rpm',
        'stock_torque_nm',
        'stock_torque_rpm',
        'stock_power_to_weight_ratio',
        'stock_torque_to_weight_ratio',
        'stock_idle_rpm',
        'stock_redline_rpm',
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
