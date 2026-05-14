<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleSuspension extends Model
{
    protected $table = 'user_vehicle_suspensions';

    protected $fillable = [
        'user_vehicle_id',
        'suspension_id',
    ];

    public function userVehicle()
    {
        return $this->belongsTo(UserVehicle::class);
    }

    public function suspension()
    {
        return $this->belongsTo(Suspension::class);
    }
}
