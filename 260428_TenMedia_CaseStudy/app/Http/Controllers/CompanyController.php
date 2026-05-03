<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class CompanyController extends Controller
{
    // Zeigt eine Liste aller Companies an.
    public function index(): View
    {
        $this->authorize('viewAny', Company::class);

        // Enthält alle Companies inklusive zugehörigem User und Anzahl der JobPostings.
        $companies = Company::with('user')
            ->withCount('jobPostings')
            ->orderBy('cmpny_name')
            ->get();

        return view('companies.index', compact('companies'));
    }

    // Zeigt das Formular zum Anlegen einer neuen Company an.
    public function create(): View|RedirectResponse
    {
        $this->authorize('create', Company::class);

        // Enthält alle User mit der Rolle provider.
        $providers = $this->getProviders();

        if ($providers->isEmpty()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Es existiert noch kein Provider. Bitte ändere zuerst die Rolle eines Users auf provider.');
        }

        return view('companies.create', compact('providers'));
    }

    // Speichert eine neue Company.
    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $this->authorize('create', Company::class);

        // Enthält die geprüften Formulardaten.
        $validatedCompanyData = $request->validated();

        // Enthält den ausgewählten Provider.
        $provider = User::where('role', 'provider')
            ->where('id', $validatedCompanyData['user_id'])
            ->firstOrFail();

        // Entfernt die Provider-Zuordnung aus den normalen Company-Daten.
        $companyDataWithoutUserId = collect($validatedCompanyData)
            ->except('user_id')
            ->toArray();

        // Erstellt die Company für den ausgewählten Provider.
        $provider->companies()->create($companyDataWithoutUserId);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Firma wurde erfolgreich erstellt.');
    }

    // Zeigt eine einzelne Company an.
    public function show(Company $company): View
    {
        $this->authorize('view', $company);

        // Lädt den zugehörigen User und die JobPostings inklusive Category.
        $company->load(['user', 'jobPostings.category']);

        return view('companies.show', compact('company'));
    }

    // Zeigt das Formular zum Bearbeiten einer Company an.
    public function edit(Company $company): View|RedirectResponse
    {
        $this->authorize('update', $company);

        // Lädt den zugeordneten User für die Anzeige im Formular.
        $company->load('user');

        // Enthält alle User mit der Rolle provider.
        $providers = $this->getProviders();

        if (auth()->user()?->role === 'admin' && $providers->isEmpty()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Es existiert noch kein Provider. Bitte ändere zuerst die Rolle eines Users auf provider.');
        }

        return view('companies.edit', compact('company', 'providers'));
    }

    // Aktualisiert eine bestehende Company.
    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('update', $company);

        // Enthält die geprüften Formulardaten.
        $validatedCompanyData = $request->validated();

        // Entfernt die Provider-Zuordnung aus den normalen Company-Daten.
        $companyDataWithoutUserId = collect($validatedCompanyData)
            ->except('user_id')
            ->toArray();

        // Aktualisiert die normalen Company-Daten.
        $company->update($companyDataWithoutUserId);

        // Admins dürfen die Company einem anderen Provider zuordnen.
        if ($request->user()->role === 'admin') {
            $provider = User::where('role', 'provider')
                ->where('id', $validatedCompanyData['user_id'])
                ->firstOrFail();

            $company->user()->associate($provider);
            $company->save();
        }

        return redirect()
            ->route('companies.index')
            ->with('success', 'Firma wurde erfolgreich aktualisiert.');
    }

    // Löscht eine bestehende Company.
    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('delete', $company);

        // Prüft, ob noch JobPostings mit dieser Company verbunden sind.
        if ($company->jobPostings()->exists()) {
            return redirect()
                ->route('companies.show', $company)
                ->with('error', 'Diese Firma kann nicht gelöscht werden, weil noch JobPostings zugeordnet sind.');
        }

        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Firma wurde erfolgreich gelöscht.');
    }

    // Lädt alle User mit der Rolle provider.
    private function getProviders(): Collection
    {
        return User::where('role', 'provider')
            ->orderBy('name')
            ->get();
    }
}
