<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEngine extends Model
{
    protected $fillable = [
        'code',
        'manufacturer',
        'displacement',
        'valve_count',
        'propulsion',
        'fuel_type',
    ];

    public function userVehicles() {
        return $this->belongsTo(UserVehicle::class);
    }

    public function specs() {
        return $this->hasMany(UserVehicleEngineSpec::class);
    }

    public function stages() {
        return $this->hasMany(UserVehicleEngineStage::class);
    }
}
