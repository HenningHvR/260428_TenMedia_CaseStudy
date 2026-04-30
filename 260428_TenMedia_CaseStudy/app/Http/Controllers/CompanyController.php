<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    // Zeigt eine Liste aller Companies an.
    public function index(): View
    {
        $this->authorize('viewAny', Company::class);

        // Lädt alle Companies inklusive User und Anzahl der zugehörigen JobPostings.
        $companies = Company::with('user')
            ->withCount('jobPostings')
            ->orderBy('cmpny_name')
            ->get();

        return view('companies.index', compact('companies'));
    }

    // Zeigt das Formular zum Anlegen einer neuen Company an.
    public function create(): View
    {
        $this->authorize('create', Company::class);

        return view('companies.create');
    }

    // Speichert eine neue Company.
    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $this->authorize('create', Company::class);

        // Enthält die geprüften Formulardaten.
        $validatedCompanyData = $request->validated();

        // Erstellt eine neue Company und ordnet sie dem aktuell eingeloggten User zu.
        $request->user()
            ->companies()
            ->create($validatedCompanyData);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Firma wurde erfolgreich erstellt.');
    }

    // Zeigt eine einzelne Company an.
    public function show(Company $company): View
    {
        $this->authorize('view', $company);

        // Lädt den zugehörigen User und alle JobPostings inklusive Category.
        $company->load(['user', 'jobPostings.category']);

        return view('companies.show', compact('company'));
    }

    // Zeigt das Formular zum Bearbeiten einer Company an.
    public function edit(Company $company): View
    {
        $this->authorize('update', $company);

        return view('companies.edit', compact('company'));
    }

    // Aktualisiert eine bestehende Company.
    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('update', $company);

        // Enthält die geprüften Formulardaten.
        $validatedCompanyData = $request->validated();

        // Aktualisiert die Company mit den geprüften Formulardaten.
        $company->update($validatedCompanyData);

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
                ->with('error', 'Diese Firma kann nicht gelöscht werden, weil ihr noch JobPostings zugeordnet sind.');
        }

        // Löscht die Company.
        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Firma wurde erfolgreich gelöscht.');
    }
}
