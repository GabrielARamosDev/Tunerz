<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicle extends Model
{
    protected $fillable = ['user_id', 'vehicle_id', 'engine_id'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    public function engines() {
        return $this->hasMany(Engine::class);
    }
}
