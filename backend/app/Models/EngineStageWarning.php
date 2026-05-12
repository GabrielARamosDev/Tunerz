<?php

namespace App\Models;

class EngineStageWarning extends Model
{
    protected $fillable = [
        'stage_id',
        'message'
    ];

    public function stage() {
        return $this->belongsTo(UserVehicleEngineStage::class, 'stage_id');
    }
}
