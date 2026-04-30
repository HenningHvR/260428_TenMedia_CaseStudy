<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    // Admins dürfen alle Aktionen ausführen.
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }

        return null;
    }

    // Prüft, ob ein User die Kategorienliste sehen darf.
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['provider', 'applicant'], true);
    }

    // Prüft, ob ein User eine Kategorie sehen darf.
    public function view(User $user, Category $category): bool
    {
        return in_array($user->role, ['provider', 'applicant'], true);
    }

    // Prüft, ob ein User eine Kategorie erstellen darf.
    public function create(User $user): bool
    {
        return false;
    }

    // Prüft, ob ein User eine Kategorie bearbeiten darf.
    public function update(User $user, Category $category): bool
    {
        return false;
    }

    // Prüft, ob ein User eine Kategorie löschen darf.
    public function delete(User $user, Category $category): bool
    {
        return false;
    }
}
