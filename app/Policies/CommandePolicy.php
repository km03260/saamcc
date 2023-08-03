<?php

namespace App\Policies;

use App\Models\Commande;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommandePolicy
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
            100, 9, 8, 10 => true,
            default => false
        };
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Commande $commande): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return match ($user->Profil) {
            100, 9, 8 => true,
            default => false
        };
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Commande $commande): bool
    {
        return match ($user->Profil) {
            100, 9 => true,
            8 => $user->clients()->first()?->id == $commande->client_id && $commande->statut_id == 1,
            default => false
        };
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function liv_confirme(User $user, Commande $commande): bool
    {
        return match ($user->Profil) {
            100, 9 => true,
            default => false
        };
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Commande $commande): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Commande $commande): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function delete(User $user, Commande $commande): bool
    {
        return match ($user->Profil) {
            100, 9 => true,
            8 => $user->clients()->first()?->id == $commande->client_id && $commande->statut_id == 1,
            default => false
        };
    }
}
