<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEngineStage extends Model
{
    protected $table = 'user_vehicle_engine_stages';

    protected $fillable = [
        'user_vehicle_engine_id', 
        'modification_type_id',
        'name',
        'boost_pressure',
        'expected_power',
        'status'
    ];

    public function userVehicleEngine() {
        return $this->belongsTo(UserVehicleEngine::class);
    }

    public function modifications() {
        return $this->hasMany(ModificationType::class);
    }
}
