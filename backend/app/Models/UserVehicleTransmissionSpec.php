<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleTransmissionSpec extends Model
{
    protected $table = 'uv_transmission_specs';
    
    protected $fillable = [
        'transmission_id',
        'user_vehicle_id',
        'gears_count',
        'gear_ratio_1',
        'gear_ratio_2',
        'gear_ratio_3',
        'gear_ratio_4',
        'gear_ratio_5',
        'gear_ratio_6',
        'gear_ratio_7',
        'final_drive_ratio',
        'clutch_diameter_mm',
        'max_torque_nm',
        'weight_kg',
        'oil_capacity_l',
    ];

    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }
}
