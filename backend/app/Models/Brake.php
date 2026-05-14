<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brake extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'manufacturer',
    ];

    public function specs()
    {
        return $this->hasOne(BrakeSpec::class);
    }

    public function parts()
    {
        return $this->hasOne(BrakePart::class);
    }

    public function userVehicles()
    {
        return $this->hasMany(UserVehicleBrake::class);
    }
}
