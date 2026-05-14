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
        return $this->hasMany(Vehicle::class);
    }

    public function specs()
    {
        return $this->hasOne(EngineSpec::class);
    }
}
