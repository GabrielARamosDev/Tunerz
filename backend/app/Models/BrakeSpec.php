<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrakeSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'brake_id',
        'rotor_diameter_mm',
        'rotor_thickness_mm',
        'pad_thickness_mm',
        'max_force_kn',
        'friction_coefficient',
        'weight_kg',
    ];

    public function brake()
    {
        return $this->belongsTo(Brake::class);
    }
}
