<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModificationType extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function engineStage() {
        return $this->belongsTo(EngineStage::class);
    }

    public function userVehicleEngineStage() {
        return $this->belongsTo(UserVehicleEngineStage::class);
    }
}
