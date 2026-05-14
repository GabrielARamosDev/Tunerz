<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransmissionSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'transmission_id',
        'gear_ratio_1',
        'gear_ratio_2',
        'gear_ratio_3',
        'gear_ratio_4',
        'gear_ratio_5',
        'final_drive_ratio',
        'weight_kg',
        'max_torque_nm',
    ];

    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }
}
