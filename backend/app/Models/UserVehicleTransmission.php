<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleTransmission extends Model
{
    protected $table = 'user_vehicle_transmissions';

    protected $fillable = [
        'user_vehicle_id',
        'clutch_type',
        'clutch_diameter_mm',
        'synchro_type',
        'material_case',
        'oil_type',
        'oil_capacity_l',
    ];

    public function userVehicle()
    {
        return $this->belongsTo(UserVehicle::class);
    }

    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }
}
