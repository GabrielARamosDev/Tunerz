<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleEnginePart extends Model
{
    protected $table = 'uv_engine_parts';

    protected $fillable = [
        'engine_id',
        'block_material',
        'head_material',
        'piston_head_type',
        'piston_head_material',
        'piston_conrod_type',
        'piston_conrod_material',
        'camshaft_material',
        'camshaft_config',
        'camshaft_actuation',
        'camshaft_type',
        'valve_material',
        'valve_type',
        'fuel_type',
        'fuel_system',
        'carburator_system',
        'intake_manifold_material',
        'intake_type',
        'intake_piping_material', 
    ];

    public function engine()
    {
        return $this->belongsTo(Engine::class);
    }
}
