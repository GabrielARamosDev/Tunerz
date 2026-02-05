<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngineStage extends Model
{
    protected $fillable = [
        'engine_id', 
        'engine_code',
        'modification_type_id',
        'name',
        'boost_pressure',
        'expected_power',
        'status'
    ];

    public function engine() {
        return $this->belongsTo(Engine::class, 'engine_id');
    }

    public function requirements() {
        return $this->hasMany(EngineStageRequirement::class);
    }

    public function warnings() {
        return $this->hasMany(EngineStageWarning::class);
    }
}
