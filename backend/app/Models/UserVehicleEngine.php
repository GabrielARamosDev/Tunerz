<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEngine extends Model
{
    protected $table = 'user_vehicle_engines';

    protected $fillable = [
        'user_vehicle_id',
        'name',
        'code',
        'manufacturer',
        'generation',
        'architecture', 
        'rotation_direction', 
        'cylinder_count',
        'valve_count',
        'camshaft_config',
        'fuel_type',
        'fuel_system',
        'carburator_system',
        'carburator_barrel_count',
        'block_material',
        'head_material',
        'length_mm',
        'width_mm',
        'height_mm',
        'weight_kg',
    ];

    public function userVehicles() {
        return $this->belongsTo(UserVehicle::class);
    }

    public function specs() {
        return $this->hasMany(UserVehicleEngineSpec::class);
    }
}
