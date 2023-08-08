<?php

namespace App\Policies;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class StockPolicy
{
    use HandlesAuthorization;

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
            100, 9, 8, 4 => true,
            default => false
        };
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Stock $stock): bool
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
    public function update(User $user): bool
    {
        return match ($user->Profil) {
            100, 9, 4 => true,
            default => false
        };
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Stock $stock): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function upStock(User $user): bool
    {
        return $user->actions->contains($this->action("3_update-stock"));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Stock $stock): bool
    {
        //
    }
}
