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
        'gear_ratio_6',
        'gear_ratio_7',
        'final_drive_ratio',
        'max_torque_nm',
        'weight_kg',
    ];

    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }
}
