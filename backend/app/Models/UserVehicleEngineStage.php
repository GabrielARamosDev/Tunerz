<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEngineStage extends Model
{
    protected $fillable = [
        'user_vehicle_engine_id', 
        'modification_type_id',
        'name',
        'boost_pressure',
        'expected_power',
        'status'
    ];

    public function requirements() {
        return $this->hasMany(EngineStageRequirement::class);
    }

    public function warnings() {
        return $this->hasMany(EngineStageWarning::class);
    }
}
