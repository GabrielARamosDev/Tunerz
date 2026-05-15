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
        'air_flow_cfm',
        'fuel_pressure_bar',
        'thermal_efficiency',
        'oil_capacity_l',
        'coolant_capacity_l',
    ];

    public function engine() {
        return $this->belongsTo(Engine::class);
    }
}
