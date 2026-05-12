<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleSpec extends Model
{
    protected $fillable = [
        'generation', 
        'platform', 
        'series',
        'drivetrain', 
        'transmission',
        'fuel_type',
        'price', 
        'price_currency',
        'weight', 
        'weight_unit',
        'width', 
        'length',
        'height',
    ];
}
