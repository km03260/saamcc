<?php

namespace App\Policies;

use App\Models\Mouvement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MouvementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view any models.
     */
    public function access(User $user): bool
    {
        return match ($user->Profil) {
            100, 9, 8 => true,
            default => false
        };
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Mouvement $mouvement): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return match ($user->Profil) {
            100, 9 => true,
            default => false
        };
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Mouvement $mouvement): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Mouvement $mouvement): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Mouvement $mouvement): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Mouvement $mouvement): bool
    {
        //
    }
}
