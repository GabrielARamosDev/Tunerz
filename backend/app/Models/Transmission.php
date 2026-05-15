<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'manufacturer',
        'type',
        'gears_count',
    ];

    public function specs()
    {
        return $this->hasOne(TransmissionSpec::class);
    }

    public function parts()
    {
        return $this->hasOne(TransmissionPart::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
