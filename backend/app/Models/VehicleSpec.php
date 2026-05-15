<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleSpec extends Model
{
    protected $fillable = [
        'vehicle_id',
        'body_type',
        'drivetrain', 
        'steering_type', 
        'length_mm',
        'width_mm', 
        'height_mm',
        'wheel_base_mm',
        'front_track_mm',
        'rear_track_mm',
        'weight_kg', 
        'fuel_tank_l',
        'drag_coefficient',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
