<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleForcedInductionPart extends Model
{
    protected $table = 'forced_induction_system_parts';

    protected $fillable = [
        'forced_induction_id', 
        'twin_turbo_config',
        'turbo_count',
        'turbine_material', 
        'turbine_blade_type', 
        'compressor_material', 
        'compressor_design', 
        'supercharger_type', 
        'supercharger_drive', 
        'supercharger_material', 
        'intercooler_type', 
        'intercooler_material', 
        'wastegate_type', 
        'wastegate_material', 
        'blow_off_valve_type', 
        'blow_off_valve_material', 
    ];

    public function forcedInduction()
    {
        return $this->belongsTo(ForcedInduction::class, 'forced_induction_id');
    }
}
