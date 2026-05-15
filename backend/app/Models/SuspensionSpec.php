<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuspensionSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'suspension_id',
        'spring_constant_nm',
        'damping_ratio',
        'ride_height_mm',
        'ground_clearance_mm',
        'camber_angle_deg',
        'caster_angle_deg',
        'toe_in_mm',
        'stabilizer_diameter_mm',
        'weight_kg',
    ];

    public function suspension()
    {
        return $this->belongsTo(Suspension::class);
    }
}
