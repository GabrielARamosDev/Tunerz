<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Engine;
use App\Models\Stage;

class Vehicle extends Model
{
    protected $fillable = [
        'brand', 
        'model', 
        'model_year', 
        'trim',
        'body_type', 
        'drivetrain', 
        'fuel_type',
        'price', 
        'price_currency',
        'weight', 
        'weight_unit',
        'width', 
        'length',
        'image_url'
    ];

    public function engines()
    {
        return $this->belongsToMany(Engine::class, 'vehicle_engine');
    }
}
