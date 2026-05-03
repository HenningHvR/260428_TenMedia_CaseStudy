<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    // Admins dürfen alle Aktionen in der Userverwaltung ausführen.
    public function before(User $user, string $ability): ?bool
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
    public function view(User $user, User $targetUser): bool
    {
        return false;
    }

    // Prüft, ob ein User bearbeitet werden darf.
    public function update(User $user, User $targetUser): bool
    {
        return false;
    }
}
