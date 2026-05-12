<?php

namespace App\Models;

class EngineStageRequirement extends Model
{
    protected $fillable = [
        'stage_id',
        'description'
    ];

    public function stage() {
        return $this->belongsTo(UserVehicleEngineStage::class, 'stage_id');
    }
}
