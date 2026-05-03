<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    // Zeigt eine Liste aller User an.
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        // Lädt alle User mit der zugehörigen Firma inklusive Anzahl der indirekt zugehörigen JobPostings.
        $users = User::with('companies')
            ->withCount('jobPostings')
            ->orderBy('name')
            ->get();

        return view('users.index', compact('users'));
    }

    // Zeigt einen einzelnen User an.
    public function show(User $user): View
    {
        $this->authorize('view', $user);

        // Lädt die Companies des Users inklusive zugehöriger JobPostings und Categories.
        $user->load(['companies.jobPostings.category']);

        return view('users.show', compact('user'));
    }

    // Zeigt das Formular zum Bearbeiten eines Users an.
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    // Aktualisiert einen bestehenden User.
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        // Validiert die Eingabedaten für Name, E-Mail, optionales Passwort und Rolle.
        $validatedUserData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:admin,provider,applicant'],
        ]);

        // Verhindert, dass ein Admin die eigene Rolle ändert.
        if ($request->user()->id === $user->id && $validatedUserData['role'] !== $user->role) {
            return redirect()
                ->route('users.edit', $user)
                ->with('error', 'Die eigene Rolle kann nicht geändert werden.');
        }

        // Enthält die aktualisierbaren Userdaten.
        $userDataToUpdate = [
            'name' => $validatedUserData['name'],
            'email' => $validatedUserData['email'],
            'role' => $validatedUserData['role'],
        ];

        // Aktualisiert das Passwort nur, wenn ein neues Passwort eingegeben wurde.
        // Das Hashing übernimmt das User-Model über den password-Cast.
        if (! empty($validatedUserData['password'])) {
            $userDataToUpdate['password'] = $validatedUserData['password'];
        }

        $user->update($userDataToUpdate);

        return redirect()
            ->route('users.index')
            ->with('success', 'User wurde erfolgreich aktualisiert.');
    }
}
