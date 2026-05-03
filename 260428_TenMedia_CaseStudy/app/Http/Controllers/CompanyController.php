<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    // Zeigt eine Liste aller Firmen an.
    public function index(): View
    {
        $this->authorize('viewAny', Company::class);

        // Lädt alle Firmen inklusive zugehöriger Provider und Anzahl der JobPostings.
        $companies = Company::with('providers')
            ->withCount('jobPostings')
            ->orderBy('cmpny_name')
            ->get();

        return view('companies.index', compact('companies'));
    }

    // Zeigt das Formular zum Anlegen einer neuen Firma an.
    public function create(): View
    {
        $this->authorize('create', Company::class);

        return view('companies.create');
    }

    // Speichert eine neue Firma.
    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $this->authorize('create', Company::class);

        // Speichert die geprüften Formulardaten.
        Company::create($request->validated());

        return redirect()
            ->route('companies.index')
            ->with('success', 'Firma wurde erfolgreich erstellt.');
    }

    // Zeigt eine einzelne Firma an.
    public function show(Company $company): View
    {
        $this->authorize('view', $company);

        // Lädt die zugeordneten Provider und JobPostings inklusive Category.
        $company->load(['providers', 'jobPostings.category']);

        return view('companies.show', compact('company'));
    }

    // Zeigt das Formular zum Bearbeiten einer Firma an.
    public function edit(Company $company): View
    {
        $this->authorize('update', $company);

        return view('companies.edit', compact('company'));
    }

    // Aktualisiert eine bestehende Firma.
    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('update', $company);

        // Aktualisiert die geprüften Formulardaten.
        $company->update($request->validated());

        return redirect()
            ->route('companies.index')
            ->with('success', 'Firma wurde erfolgreich aktualisiert.');
    }

    // Löscht eine bestehende Firma.
    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('delete', $company);

        // Prüft, ob noch JobPostings mit dieser Firma verbunden sind.
        if ($company->jobPostings()->exists()) {
            return redirect()
                ->route('companies.show', $company)
                ->with('error', 'Diese Firma kann nicht gelöscht werden, weil noch JobPostings zugeordnet sind.');
        }

        // Prüft, ob noch Provider mit dieser Firma verbunden sind.
        if ($company->providers()->exists()) {
            return redirect()
                ->route('companies.show', $company)
                ->with('error', 'Diese Firma kann nicht gelöscht werden, weil noch Provider zugeordnet sind.');
        }

        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Firma wurde erfolgreich gelöscht.');
    }
}
