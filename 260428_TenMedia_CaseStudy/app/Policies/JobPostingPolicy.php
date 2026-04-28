<?php

namespace App\Policies;

use App\Models\JobPosting;
use App\Models\User;

class JobPostingPolicy
{

    // Admins dürfen alle Aktionen ausführen.

    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }

        return null;
    }


    // * Prüft, ob ein User die JobPosting-Liste sehen darf.

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['provider', 'applicant']);
    }


    // Prüft, ob ein User ein einzelnes JobPosting sehen darf.

    public function view(User $user, JobPosting $jobPosting): bool
    {
        return in_array($user->role, ['provider', 'applicant']);
    }


    // Prüft, ob ein User ein JobPosting erstellen darf.

    public function create(User $user): bool
    {
        return $user->role === 'provider';
    }


    // Prüft, ob ein User ein JobPosting bearbeiten darf.

    public function update(User $user, JobPosting $jobPosting): bool
    {
        return $user->role === 'provider'
            && $jobPosting->company
            && $jobPosting->company->user_id === $user->id;
    }


    // Prüft, ob ein User ein JobPosting löschen darf.

    public function delete(User $user, JobPosting $jobPosting): bool
    {
        return $this->update($user, $jobPosting);
    }


    // Prüft, ob ein User ein gelöschtes JobPosting wiederherstellen darf.

    public function restore(User $user, JobPosting $jobPosting): bool
    {
        return false;
    }


    // Prüft, ob ein User ein JobPosting endgültig löschen darf.

    public function forceDelete(User $user, JobPosting $jobPosting): bool
    {
        return false;
    }
}
