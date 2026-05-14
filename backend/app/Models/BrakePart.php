<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrakePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'brake_id',
        'rotor_type',
        'rotor_material',
        'caliper_type',
        'caliper_material',
        'pad_type',
        'pad_compound',
        'dust_shield',
    ];

    public function brake()
    {
        return $this->belongsTo(Brake::class);
    }
}
