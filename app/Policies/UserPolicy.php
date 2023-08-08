<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
            100, 9 => true,
            default => false
        };
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
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
    public function update(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return match ($user->Profil) {
            100 => true,
            9 => $model->Profil == 8,
                // 8 => $model->Profil == 8 && $model->clients()->first()?->id && $user->clients()->contains($model->clients()->first()->id),
            default => false
        };
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function is_client(User $user): bool
    {
        return $user->Profil == 8;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function is_operateur(User $user): bool
    {
        return $user->Profil == 4;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }
}
