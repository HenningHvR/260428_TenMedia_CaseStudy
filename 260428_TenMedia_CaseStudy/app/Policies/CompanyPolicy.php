<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    // Admins dürfen alle Aktionen ausführen.
    public function before(User $user, string $ability): ?bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        return null;
    }

    // Prüft, ob ein User die Firmenliste sehen darf.
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['provider', 'applicant'], true);
    }

    // Prüft, ob ein User eine einzelne Firma sehen darf.
    public function view(User $user, Company $company): bool
    {
        return in_array($user->role, ['provider', 'applicant'], true);
    }

    // Prüft, ob ein User eine Firma erstellen darf.
    // Admins werden über before() erlaubt.
    public function create(User $user): bool
    {
        return false;
    }

    // Prüft, ob ein User eine Firma bearbeiten darf.
    public function update(User $user, Company $company): bool
    {
        return $user->role === 'provider'
            && $company->user_id === $user->id;
    }

    // Prüft, ob ein User eine Firma löschen darf.
    public function delete(User $user, Company $company): bool
    {
        return $this->update($user, $company);
    }
}
