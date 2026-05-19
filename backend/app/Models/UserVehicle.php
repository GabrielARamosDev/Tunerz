<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicle extends Model
{
    protected $table = 'user_vehicles';

    protected $fillable = [
        'base_vehicle_id', 
        'user_id',
        'manufacturer',
        'model',
        'trim',
        'year',
        'generation',
        'engine_id',
        'transmission_id',
        'forced_induction_id',
        'front_suspension_id',
        'rear_suspension_id',
        'front_brake_id',
        'rear_brake_id',
        'front_wheel_id',
        'rear_wheel_id',
        'image_url',
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
    public function engineParts()
    {
        return $this->hasMany(UserVehicleEnginePart::class);
    }
    public function engineSpecs()
    {
        return $this->hasMany(UserVehicleEngineSpec::class);
    }
    
    public function transmission()
    {
        return $this->belongsTo(Transmission::class);
    }
    public function transmissionParts()
    {
        return $this->hasMany(UserVehicleTransmissionPart::class);
    }
    public function transmissionSpecs()
    {
        return $this->hasMany(UserVehicleTransmissionSpec::class);
    }
    
    public function forcedInduction()
    {
        return $this->belongsTo(ForcedInduction::class);
    }
    public function forcedInductionParts()
    {
        return $this->hasMany(UserVehicleForcedInductionPart::class);
    }
    public function forcedInductionSpecs()
    {
        return $this->hasMany(UserVehicleForcedInductionSpec::class);
    }
    
    public function frontSuspension()
    {
        return $this->belongsTo(Suspension::class);
    }
    public function frontSuspensionParts()
    {
        return $this->hasMany(UserVehicleSuspensionPart::class);
    }
    public function frontSuspensionSpecs()
    {
        return $this->hasMany(UserVehicleSuspensionSpec::class);
    }
    public function rearSuspension()
    {
        return $this->belongsTo(Suspension::class);
    }
    public function rearSuspensionParts()
    {
        return $this->hasMany(UserVehicleSuspensionPart::class);
    }
    public function rearSuspensionSpecs()
    {
        return $this->hasMany(UserVehicleSuspensionSpec::class);
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
}
