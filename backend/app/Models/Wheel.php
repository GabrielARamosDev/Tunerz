<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wheel extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'manufacturer',
    ];

    public function specs()
    {
        return $this->hasOne(WheelSpec::class);
    }

    public function parts()
    {
        return $this->hasOne(WheelPart::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
