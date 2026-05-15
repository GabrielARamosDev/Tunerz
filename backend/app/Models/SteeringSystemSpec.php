<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SteeringSystemSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'front_suspension_height_mm',
        'rear_suspension_height_mm',
        'front_tire_pressure_bar',
        'rear_tire_pressure_bar',
        'front_wheel_camber',
        'rear_wheel_camber',
        'front_wheel_toe',
        'rear_wheel_toe',
    ];
}
