<?php

namespace App\Policies;

use App\Models\BrakeSpec;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BrakeSpecPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BrakeSpec $brakeSpec): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BrakeSpec $brakeSpec): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BrakeSpec $brakeSpec): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BrakeSpec $brakeSpec): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BrakeSpec $brakeSpec): bool
    {
        //
    }
}
