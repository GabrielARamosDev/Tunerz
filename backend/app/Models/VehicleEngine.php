<?php

namespace App\Models;

class VehicleEngine extends Model
{
    protected $table = 'vehicle_engine';

    protected $fillable = [
        'vehicle_id',
        'engine_id',
    ];
}
