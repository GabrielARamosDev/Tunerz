<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicle extends Model
{
    protected $table = 'user_vehicles';

    protected $fillable = [
        'user_id', 
        'vehicle_id', 
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

    public function engines() {
        return $this->hasMany(UserVehicleEngine::class);
    }

    public function transmissions()
    {
        return $this->hasMany(UserVehicleTransmission::class);
    }

    public function brakes()
    {
        return $this->hasMany(UserVehicleBrake::class);
    }

    public function suspensions()
    {
        return $this->hasMany(UserVehicleSuspension::class);
    }

    /* */

    public static function mountFrontendModel(UserVehicle $item) {

        $item = $item->toArray();

        $specs = $item['vehicle_specs'] ?? [];
        $engines = $item['engines'] ?? [];
        $transmissions = $item['transmissions'] ?? [];
        $brakes = $item['brakes'] ?? [];
        $suspensions = $item['suspensions'] ?? [];
        
        $item['vehicle']['specs'] = $specs;
        $item['vehicle']['engines'] = $engines;
        $item['vehicle']['transmissions'] = $transmissions;
        $item['vehicle']['brakes'] = $brakes;
        $item['vehicle']['suspensions'] = $suspensions;
        
        unset($item['vehicle_specs']);
        unset($item['engines']);
        unset($item['transmissions']);
        unset($item['brakes']);
        unset($item['suspensions']);

        $vehicle = $item;

        return $vehicle;
    }

}
