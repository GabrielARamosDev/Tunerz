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

    /* */

    public static function mountFrontendModel(UserVehicle $item) {

        $item = $item->toArray();

        $specs = $item['vehicle_specs'];
        $engines = $item['engines'];
        
        $item['vehicle']['specs'] = $specs;
        $item['vehicle']['engines'] = $engines;
        
        unset($item['vehicle_specs']);
        unset($item['engines']);

        $vehicle = $item;

        return $vehicle;
    }

}
