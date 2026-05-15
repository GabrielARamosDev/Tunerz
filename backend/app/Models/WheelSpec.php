<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WheelSpec extends Model
{
    use HasFactory;

    protected $fillable = [
        'wheel_id',
        'tire_width_mm',
        'tire_profile',
        'wheel_radius_in',
        'wheel_material',
        'expected_pressure_bar',
    ];

    public function wheel()
    {
        return $this->belongsTo(Wheel::class);
    }
}
