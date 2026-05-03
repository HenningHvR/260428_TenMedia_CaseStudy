<?php

namespace App\Http\Controllers;

use App\Models\Company;
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

        // Lädt alle User inklusive zugehöriger Firma und Anzahl der indirekt zugehörigen JobPostings.
        $users = User::with('company')
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

        // Lädt die aktuell zugeordnete Firma des Users.
        $user->load('company');

        // Lädt alle Firmen inklusive aktuell zugeordnetem Provider.
        $companies = Company::with('user')
            ->orderBy('cmpny_name')
            ->get();

        return view('users.edit', compact('user', 'companies'));
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

    // Ordnet einem Provider genau eine bestehende Firma zu.
    public function assignCompany(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        // Prüft, ob der ausgewählte User wirklich Provider ist.
        if ($user->role !== 'provider') {
            return redirect()
                ->route('users.edit', $user)
                ->with('error', 'Firmen können nur Usern mit der Rolle provider zugeordnet werden.');
        }

        // Validiert die ausgewählte Firma.
        $validatedCompanyData = $request->validate([
            'company_id' => [
                'required',
                Rule::exists('companies', 'id'),
            ],
        ]);

        // Prüft, ob der Provider bereits eine andere Firma besitzt.
        $providerAlreadyHasAnotherCompany = $user->company()
            ->where('id', '!=', $validatedCompanyData['company_id'])
            ->exists();

        if ($providerAlreadyHasAnotherCompany) {
            return redirect()
                ->route('users.edit', $user)
                ->withInput()
                ->with('error', 'Dieser Provider besitzt bereits eine andere Firma.');
        }

        // Lädt die ausgewählte Firma.
        $company = Company::findOrFail($validatedCompanyData['company_id']);

        // Ordnet die Firma dem Provider zu.
        $company->user()->associate($user);
        $company->save();

        return redirect()
            ->route('users.edit', $user)
            ->with('success', 'Firma wurde dem Provider erfolgreich zugeordnet.');
    }
}
