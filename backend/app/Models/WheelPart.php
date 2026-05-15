<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WheelPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'wheel_id',
        'tire_material',
        'wheel_material',
    ];

    public function wheel()
    {
        return $this->belongsTo(Wheel::class);
    }
}
