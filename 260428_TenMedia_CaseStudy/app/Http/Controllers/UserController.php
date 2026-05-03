<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Validation\Rule;
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

        // Lädt die Companies des Users inklusive zugehöriger JobPostings und Categories.
        $user->load(['companies.jobPostings.category']);

        return view('users.show', compact('user'));
    }

    // Zeigt das Formular zum Bearbeiten eines Users an.
    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        // Lädt die aktuell zugeordnete Company des Users.
        $user->load('companies');

        // Enthält alle Companies für die Provider-Zuordnung durch Admins.
        $companies = Company::with('user')
            ->orderBy('cmpny_name')
            ->get();

        return view('users.edit', compact('user', 'companies'));
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

    // Ordnet einem Provider genau eine bestehende Company zu.
    public function assignCompany(Request $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        // Prüft, ob der ausgewählte User wirklich Provider ist.
        if ($user->role !== 'provider') {
            return redirect()
                ->route('users.edit', $user)
                ->with('error', 'Companies können nur Usern mit der Rolle provider zugeordnet werden.');
        }

        // Validiert die ausgewählte Company.
        $validatedCompanyData = $request->validate([
            'company_id' => [
                'required',
                Rule::exists('companies', 'id'),
            ],
        ]);

        // Prüft, ob der Provider bereits eine andere Company besitzt.
        $alreadyAssignedCompany = $user->companies()
            ->where('id', '!=', $validatedCompanyData['company_id'])
            ->first();

        if ($alreadyAssignedCompany) {
            return redirect()
                ->route('users.edit', $user)
                ->with('error', 'Dieser Provider besitzt bereits eine Company. Bitte ordne zuerst die bestehende Company einem anderen Provider zu.');
        }

        // Lädt die ausgewählte Company.
        $company = Company::findOrFail($validatedCompanyData['company_id']);

        // Ordnet die Company dem Provider zu.
        $company->user()->associate($user);
        $company->save();

        return redirect()
            ->route('users.edit', $user)
            ->with('success', 'Company wurde dem Provider erfolgreich zugeordnet.');
    }
}
