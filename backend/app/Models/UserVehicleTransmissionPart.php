<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleTransmissionPart extends Model
{
    protected $table = 'uv_transmission_parts';
    
    protected $fillable = [
        'transmission_id',
        'clutch_type',
        'synchro_type',
        'material_case',
    ];

    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }
}
