<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicle extends Model
{
    protected $table = 'user_vehicles';

    protected $fillable = [
        'user_id', 
        'manufacturer', 
        'model', 
        'trim',
        'year',
        'generation', 
        'engine_id',
        'transmission_id',
        'front_suspension_id',
        'rear_suspension_id',
        'front_brake_id',
        'rear_brake_id', 
        'front_wheel_id',
        'rear_wheel_id', 
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function specs()
    {
        return $this->hasMany(UserVehicleSpecs::class);
    }

    public function engine()
    {
        return $this->belongsTo(Engine::class);
    }
    
    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }
    
    public function frontSuspension()
    {
        return $this->belongsTo(Suspension::class);
    }
    public function rearSuspension()
    {
        return $this->belongsTo(Suspension::class);
    }
    
    public function frontBrake()
    {
        return $this->belongsTo(Brake::class);
    }
    public function rearBrake()
    {
        return $this->belongsTo(Brake::class);
    }
    
    public function frontWheel()
    {
        return $this->belongsTo(Wheel::class);
    }
    public function rearWheel()
    {
        return $this->belongsTo(Wheel::class);
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
