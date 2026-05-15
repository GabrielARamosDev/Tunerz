<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleSpecs extends Model
{
    protected $table = 'user_vehicle_specs';

    protected $fillable = [
        'user_vehicle_id',
        'body_type',
        'drivetrain', 
        'length_mm',
        'width_mm', 
        'height_mm',
        'wheel_base_mm',
        'front_track_mm',
        'rear_track_mm',
        'weight_kg', 
        'fuel_tank_l',
        'drag_coefficient'
    ];

    public function userVehicle() {
        return $this->belongsTo(UserVehicle::class);
    }
}
