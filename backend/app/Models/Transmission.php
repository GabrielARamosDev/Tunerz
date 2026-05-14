<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'gears_count',
        'manufacturer',
    ];

    public function specs()
    {
        return $this->hasOne(TransmissionSpec::class);
    }

    public function parts()
    {
        return $this->hasOne(TransmissionPart::class);
    }

    public function userVehicles()
    {
        return $this->hasMany(UserVehicleTransmission::class);
    }
}
