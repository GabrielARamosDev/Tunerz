<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnginePart extends Model
{
    protected $fillable = [
        'engine_id',
        'piston_head_type',
        'piston_head_material',
        'piston_conrod_type',
        'piston_conrod_material',
        'piston_bore_mm',
        'piston_stroke_mm',
        'camshaft_type',
        'camshaft_material',
        'valve_type',
        'valve_material',
        'intake_valve_diameter_mm',
        'intake_valve_seat_angle',
        'exhaust_valve_diameter_mm',
        'exhaust_valve_seat_angle',
        'valve_control_type',
        'valve_control_material',
        'has_VVT',
        'has_VVL',
    ];

    public function engine()
    {
        return $this->belongsTo(Engine::class);
    }
}
