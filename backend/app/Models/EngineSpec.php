<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EngineSpec extends Model
{
    protected $fillable = [
        'engine_id', 
        'engine_code',
        'cylinders',
        'aspiration',
        'stock_power_hp',
        'stock_torque_nm',
        'configuration',
        'compression_ratio',
        'bore_mm',
        'stroke_mm',
    ];

    public function engine() {
        return $this->belongsTo(Engine::class);
    }
}
