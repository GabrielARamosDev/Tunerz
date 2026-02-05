<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEngine extends Model
{
    protected $fillable = ['user_vehicle_id', 'stage_id', 'spec_id'];

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
