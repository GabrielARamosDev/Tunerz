<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEngine extends Model
{
    protected $table = 'user_vehicle_engines';

    protected $fillable = [
        'user_vehicle_id',
        'piston_head_type',
        'piston_head_material',
        'piston_conrod_type',
        'piston_conrod_material',
        'piston_bore_mm',
        'piston_stroke_mm',
        'compression_ratio',
        'displacement_cc',
        'camshaft_type',
        'camshaft_material',
        'valve_type',
        'valve_material',
        'intake_valve_diameter_mm',
        'intake_valve_seat_angle',
        'exhaust_valve_diameter_mm',
        'exhaust_valve_seat_angle',
        'has_VVT',
        'has_VVL',
        'aspiration',
        'max_safe_boost_bar',
    ];

    public function userVehicles() {
        return $this->belongsTo(UserVehicle::class);
    }

    public function specs() {
        return $this->hasMany(UserVehicleEngineSpec::class);
    }
}
