<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForcedInduction extends Model
{
    use HasFactory;

    protected $table = 'forced_induction_systems';

    protected $fillable = [
        'code',
        'name',
        'manufacturer',
        'type',
        'twin_turbo_config',
        'twin_turbo_count',
        'supercharger_config',
    ];

    public function specs()
    {
        return $this->hasOne(ForcedInductionSpec::class);
    }

    public function parts()
    {
        return $this->hasOne(ForcedInductionPart::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
