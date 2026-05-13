<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Engine;

class Vehicle extends Model
{
    protected $fillable = [
        'manufacturer', 
        'model', 
        'year', 
        'trim',
        'engine_id',
        'body_type', 
        'image_url'
    ];
    
    public function engine()
    {
        return $this->belongsTo(Engine::class);
    }

    public function specs()
    {
        return $this->hasMany(VehicleSpec::class);
    }
}
