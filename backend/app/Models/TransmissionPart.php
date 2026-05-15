<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransmissionPart extends Model
{
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
