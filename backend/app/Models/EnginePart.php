<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnginePart extends Model
{
    protected $fillable = [
        'engine_id',
        'block_material',
        'head_material',
        'piston_head_type',
        'piston_head_material',
        'piston_conrod_type',
        'piston_conrod_material',
        'camshaft_config',
        'camshaft_actuation',
        'camshaft_type',
        'camshaft_material',
        'valve_type',
        'valve_material',
        'fuel_type',
        'fuel_system',
        'carburator_system',
        'aspiration',
        'twin_turbocharged_config', 
    ];

    public function engine()
    {
        return $this->belongsTo(Engine::class);
    }
}
