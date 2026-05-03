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

    // Prüft, ob ein User die JobPosting-Liste sehen darf.
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['provider', 'applicant'], true);
    }

    // Prüft, ob ein User ein einzelnes JobPosting sehen darf.
    public function view(User $user, JobPosting $jobPosting): bool
    {
        return in_array($user->role, ['provider', 'applicant'], true);
    }

    // Prüft, ob ein User ein JobPosting erstellen darf.
    public function create(User $user): bool
    {
        return $user->role === 'provider';
    }

    public function update(User $user, JobPosting $jobPosting): bool
    {
        return $user->role === 'provider'
            && $user->company_id === $jobPosting->company_id;
    }

    public function delete(User $user, JobPosting $jobPosting): bool
    {
        return $this->update($user, $jobPosting);
    }
}
