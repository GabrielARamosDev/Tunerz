<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    protected $fillable = [
        'name',
        'code',
        'manufacturer',
        'generation',
        'architecture', 
        'rotation_direction', 
    ];

    public function specs()
    {
        return $this->hasOne(EngineSpec::class);
    }

    public function parts()
    {
        return $this->hasOne(EnginePart::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
