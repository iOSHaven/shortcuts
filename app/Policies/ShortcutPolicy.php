<?php

namespace App\Policies;

use App\Models\Shortcut;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ShortcutPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Shortcut $shortcut): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shortcut $shortcut): bool
    {
        return $this->isAuthor($user, $shortcut);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Shortcut $shortcut): bool
    {
        return $this->isAuthor($user, $shortcut);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Shortcut $shortcut): bool
    {
        return $this->isAuthor($user, $shortcut);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Shortcut $shortcut): bool
    {
        return $this->isAuthor($user, $shortcut);
    }

    /**
     * Check if user is an author of shortcut.
     */
    public function isAuthor(User $user, Shortcut $shortcut): bool
    {
        return $shortcut->authors()->where("users.id", $user->id)->exists();
    }
}
