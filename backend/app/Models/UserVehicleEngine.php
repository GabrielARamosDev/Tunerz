<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEngine extends Model
{
    protected $table = 'user_vehicle_engine';

    protected $fillable = [
        'user_vehicle_id', 
        'code',
        'manufacturer',
        'displacement',
        'valve_count',
        'propulsion',
        'fuel_type',
    ];

    public function userVehicle() {
        return $this->belongsTo(UserVehicle::class);
    }

    public function stage() {
        return $this->hasOne(UserVehicleEngineStage::class);
    }

    public function specs() {
        return $this->hasMany(UserVehicleEngineSpec::class);
    }
}
