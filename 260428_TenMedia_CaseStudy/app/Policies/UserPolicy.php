<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    // Admins dürfen alle Aktionen ausführen.
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }

        return null;
    }

    // Prüft, ob ein User die Userliste sehen darf.
    public function viewAny(User $user): bool
    {
        return false;
    }

    // Prüft, ob ein User einen einzelnen User sehen darf.
    public function view(User $user, User $model): bool
    {
        return false;
    }

    // Prüft, ob ein User einen User bearbeiten darf.
    public function update(User $user, User $model): bool
    {
        return false;
    }

    // Prüft, ob ein User einen User löschen darf.
    public function delete(User $user, User $model): bool
    {
        return false;
    }
}
