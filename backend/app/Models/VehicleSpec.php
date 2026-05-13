<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleSpec extends Model
{
    protected $fillable = [
        'vehicle_id',
        'generation', 
        'platform', 
        'series',
        'drivetrain', 
        'transmission',
        'fuel_type',
        'weight', 
        'weight_unit',
        'width', 
        'length',
        'height',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
