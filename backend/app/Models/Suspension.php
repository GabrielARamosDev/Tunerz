<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'manufacturer',
        'type',
        'configuration',
    ];

    public function specs()
    {
        return $this->hasOne(SuspensionSpec::class);
    }

    public function parts()
    {
        return $this->hasOne(SuspensionPart::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
