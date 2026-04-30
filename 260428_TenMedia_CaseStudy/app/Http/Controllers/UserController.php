<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    // Zeigt eine Liste aller User an.
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        // Lädt alle User inklusive Anzahl der indirekt zugehörigen JobPostings.
        $users = User::withCount('jobPostings')
            ->orderBy('name')
            ->get();

        return view('users.index', compact('users'));
    }

    // Zeigt einen einzelnen User an.
    public function show(User $user): View
    {
        $this->authorize('view', $user);

        return view('users.show', compact('user'));
    }

    // Zeigt das Formular zum Bearbeiten eines Users an.
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    // Aktualisiert die Rolle eines Users.
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        // Verhindert, dass ein Admin die eigene Rolle ändert.
        if ($request->user()->id === $user->id) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Die eigene Rolle kann nicht geändert werden.');
        }

        // Validiert die Rolle.
        $validatedUserData = $request->validate([
            'role' => ['required', 'in:admin,provider,applicant'],
        ]);

        // Aktualisiert die Rolle des Users.
        $user->update($validatedUserData);

        return redirect()
            ->route('users.index')
            ->with('success', 'User-Rolle wurde erfolgreich aktualisiert.');
    }
}
