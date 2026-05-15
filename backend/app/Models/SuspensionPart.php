<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuspensionPart extends Model
{
    use HasFactory;

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
