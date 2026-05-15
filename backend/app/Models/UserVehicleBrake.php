<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleBrake extends Model
{
    protected $table = 'user_vehicle_brakes';

    protected $fillable = [
        'user_vehicle_id',
        'rotor_type',
        'rotor_material',
        'caliper_type',
        'caliper_material',
        'pad_type',
        'pad_compound',
        'dust_shield',
    ];

    public function userVehicle()
    {
        return $this->belongsTo(UserVehicle::class);
    }

    public function brake()
    {
        return $this->belongsTo(Brake::class);
    }
}
