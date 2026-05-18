<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVehicleSuspensionPart extends Model
{
    protected $table = 'uv_suspension_parts';
    
    protected $fillable = [
        'suspension_id',
        'spring_type',
        'spring_material',
        'damper_type',
        'damper_material',
        'has_abs',
    ];

    public function suspension()
    {
        return $this->belongsTo(Suspension::class);
    }
}
