<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    protected $fillable = [
        'code',
        'manufacturer',
        'displacement',
        'valve_count',
        'propulsion',
        'fuel_type',
    ];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'vehicle_engine');
    }

    public function stages()
    {
        return $this->hasMany(EngineStage::class);
    }
}
