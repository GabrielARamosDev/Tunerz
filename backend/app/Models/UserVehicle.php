<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicle extends Model
{
    protected $table = 'user_vehicles';

    protected $fillable = [
        'user_id', 
        'vehicle_id', 
        'engine_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function vehicleSpecs()
    {
        return $this->hasMany(UserVehicleSpecs::class);
    }

    public function engine() {
        return $this->belongsTo(UserVehicleEngine::class);
    }
}
