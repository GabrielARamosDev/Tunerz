<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleSpecs extends Model
{
    protected $table = 'user_vehicle_specs';

    protected $fillable = [
        'user_vehicle_id',
        'generation',
        'platform',
        'series',
        'drivetrain',
        'transmission',
        'price',
        'price_currency',
        'weight',
        'weight_unit',
        'width',
        'length',
        'height'
    ];

    public function userVehicle() {
        return $this->belongsTo(UserVehicle::class);
    }
}
