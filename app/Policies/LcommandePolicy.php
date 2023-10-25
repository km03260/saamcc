<?php

namespace App\Policies;

use App\Models\Commande;
use App\Models\Lcommande;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LcommandePolicy
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
    public function view(User $user, Lcommande $lcommande): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Commande $commande): bool
    {
        return match ($user->Profil) {
            100, 9 => $commande->statut_id == 1,
            8 => $user->clients()->first()?->id == $commande->client_id && $commande->statut_id == 1,
            default => false
        };
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lcommande $lcommande, String $attribute = ''): bool
    {
        return match ($user->Profil) {
            100, 9 => in_array($attribute, ['statut_id']) || $lcommande->commande->statut_id == 1,
            8 => $user->clients()->first()?->id == $lcommande->commande->client_id && $lcommande->commande->statut_id == 1,
            default => false
        };
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lcommande $lcommande): bool
    {
        return match ($user->Profil) {
            100, 9 => $lcommande->commande->statut_id == 1,
            8 => $user->clients()->first()?->id == $lcommande->commande->client_id && $lcommande->commande->statut_id == 1,
            default => false
        };
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lcommande $lcommande): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lcommande $lcommande): bool
    {
        //
    }
}
