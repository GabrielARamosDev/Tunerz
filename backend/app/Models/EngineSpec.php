<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngineSpec extends Model
{
    protected $fillable = [
        'engine_id',
        'stock_power_hp',
        'stock_power_rpm',
        'stock_torque_nm',
        'stock_torque_rpm',
        'stock_power_to_weight_ratio',
        'stock_torque_to_weight_ratio',
        'stock_redline_rpm',
        'stock_idle_rpm',
        'cylinders_count',
        'piston_bore_mm',
        'piston_stroke_mm',
        'compression_ratio',
        'displacement_cc',
        'valve_count',
        'intake_valve_diameter_mm',
        'intake_valve_seat_angle',
        'exhaust_valve_diameter_mm',
        'exhaust_valve_seat_angle',
        'carburator_barrel_count',
        'air_flow_cfm',
        'max_safe_boost_bar',
        'fuel_pressure_bar',
        'thermal_efficiency',
        'oil_capacity_l',
        'coolant_capacity_l',
        'length_mm',
        'width_mm',
        'height_mm',
        'weight_kg',
    ];

    public function engine() {
        return $this->belongsTo(Engine::class);
    }
}
