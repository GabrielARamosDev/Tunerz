<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngineStage extends Model
{
    protected $fillable = [
        'engine_id', 
        'modification_type_id',
        'name',
        'boost_pressure',
        'expected_power',
        'status'
    ];

    public function engine() {
        return $this->belongsTo(Engine::class);
    }

    public function modifications() {
        return $this->hasMany(ModificationType::class);
    }
}
