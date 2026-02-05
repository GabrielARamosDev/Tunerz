<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEngineSpec extends Model
{
    protected $fillable = [
        'user_vehicle_engine_id', 
        'cylinders',
        'aspiration',
        'stock_power_hp',
        'stock_torque_nm',
        'configuration',
        'compression_ratio',
        'bore_mm',
        'stroke_mm',
    ];
}
