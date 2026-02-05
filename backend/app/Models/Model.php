<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['deleted_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Scope to get only active records (not soft deleted)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Scope to get only soft deleted records
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTrashed($query)
    {
        return $query->whereNotNull('deleted_at');
    }

    /**
     * Scope to get all records including soft deleted ones
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithTrashed($query)
    {
        return $query->withoutGlobalScopes();
    }

    /**
     * Boot the model
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically update timestamps
        static::creating(function ($model) {
            if (is_null($model->created_at)) {
                $model->created_at = now();
            }
        });

        static::updating(function ($model) {
            $model->updated_at = now();
        });
    }

    /**
     * Get the model's relationships
     *
     * @return array
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * Convert the model instance to an array
     *
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();

        // Remove deleted_at from the array as it's hidden
        unset($array['deleted_at']);

        return $array;
    }

    /**
     * Get the route key for the model
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->getKeyName();
    }
}
