<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobPostingRequest;
use App\Http\Requests\UpdateJobPostingRequest;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobPostingController extends Controller
{
    // Zeigt eine Liste aller JobPostings an.
    public function index(): View
    {
        $this->authorize('viewAny', JobPosting::class);

        // Enthält alle JobPostings inklusive zugehöriger Company und Category.
        $jobPostings = JobPosting::with(['company', 'category'])
            ->latest()
            ->get();

        return view('job_postings.index', compact('jobPostings'));
    }

    // Zeigt das Formular zum Anlegen eines neuen JobPostings an.
    public function create(): View
    {
        $this->authorize('create', JobPosting::class);

        // Enthält den aktuell eingeloggten User.
        $currentUser = auth()->user();

        // Enthält die Companies, die der aktuelle User für JobPostings verwenden darf.
        $companies = $this->getSelectableCompaniesForUser($currentUser);

        // Enthält alle verfügbaren Kategorien.
        $categories = Category::orderBy('ctgry_name')->get();

        return view('job_postings.create', compact('companies', 'categories'));
    }

    // Speichert ein neues JobPosting.
    public function store(StoreJobPostingRequest $request): RedirectResponse
    {
        $this->authorize('create', JobPosting::class);

        // Enthält die geprüften Eingabedaten aus dem Formular.
        $validatedJobPostingData = $request->validated();

        // Setzt den Aktivstatus sauber als booleschen Wert.
        $validatedJobPostingData['is_active'] = $request->boolean('is_active', true);

        // Enthält den aktuell eingeloggten User.
        $currentUser = $request->user();

        // Enthält die Company, die der aktuelle User verwenden darf.
        $company = $this->findSelectableCompanyForUser(
            $currentUser,
            (int) $validatedJobPostingData['company_id']
        );

        // Enthält die ausgewählte Category.
        $category = Category::findOrFail($validatedJobPostingData['category_id']);

        // Enthält nur die normalen JobPosting-Daten ohne Fremdschlüssel.
        $jobPostingDataWithoutForeignKeys = $this->getJobPostingDataWithoutForeignKeys($validatedJobPostingData);

        // Enthält das neue JobPosting ohne direkte Fremdschlüssel-Zuweisung.
        $jobPosting = new JobPosting($jobPostingDataWithoutForeignKeys);

        // Verknüpft das JobPosting mit der Category.
        $jobPosting->category()->associate($category);

        // Verknüpft das JobPosting mit der Company und speichert es.
        $company->jobPostings()->save($jobPosting);

        return redirect()
            ->route('job-postings.index')
            ->with('success', 'JobPosting wurde erfolgreich erstellt.');
    }

    // Zeigt ein einzelnes JobPosting an.
    public function show(JobPosting $jobPosting): View
    {
        $this->authorize('view', $jobPosting);

        // Lädt die zugehörigen Beziehungen für die Detailansicht.
        $jobPosting->load(['company', 'category']);

        return view('job_postings.show', compact('jobPosting'));
    }

    // Zeigt das Formular zum Bearbeiten eines JobPostings an.
    public function edit(JobPosting $jobPosting): View
    {
        $this->authorize('update', $jobPosting);

        // Enthält den aktuell eingeloggten User.
        $currentUser = auth()->user();

        // Enthält die Companies, die der aktuelle User für JobPostings verwenden darf.
        $companies = $this->getSelectableCompaniesForUser($currentUser);

        // Enthält alle verfügbaren Kategorien.
        $categories = Category::orderBy('ctgry_name')->get();

        return view('job_postings.edit', compact('jobPosting', 'companies', 'categories'));
    }

    // Aktualisiert ein bestehendes JobPosting.
    public function update(UpdateJobPostingRequest $request, JobPosting $jobPosting): RedirectResponse
    {
        $this->authorize('update', $jobPosting);

        // Enthält die geprüften Eingabedaten aus dem Formular.
        $validatedJobPostingData = $request->validated();

        // Setzt den Aktivstatus sauber als booleschen Wert.
        $validatedJobPostingData['is_active'] = $request->boolean('is_active');

        // Enthält den aktuell eingeloggten User.
        $currentUser = $request->user();

        // Enthält die Company, die der aktuelle User verwenden darf.
        $company = $this->findSelectableCompanyForUser(
            $currentUser,
            (int) $validatedJobPostingData['company_id']
        );

        // Enthält die ausgewählte Category.
        $category = Category::findOrFail($validatedJobPostingData['category_id']);

        // Enthält nur die normalen JobPosting-Daten ohne Fremdschlüssel.
        $jobPostingDataWithoutForeignKeys = $this->getJobPostingDataWithoutForeignKeys($validatedJobPostingData);

        // Aktualisiert die normalen Attribute des JobPostings.
        $jobPosting->update($jobPostingDataWithoutForeignKeys);

        // Aktualisiert die Company-Zuordnung.
        $jobPosting->company()->associate($company);

        // Aktualisiert die Category-Zuordnung.
        $jobPosting->category()->associate($category);

        // Speichert die geänderten Zuordnungen.
        $jobPosting->save();

        return redirect()
            ->route('job-postings.index')
            ->with('success', 'JobPosting wurde erfolgreich aktualisiert.');
    }

    // Löscht ein bestehendes JobPosting.
    public function destroy(JobPosting $jobPosting): RedirectResponse
    {
        $this->authorize('delete', $jobPosting);

        // Löscht das JobPosting.
        $jobPosting->delete();

        return redirect()
            ->route('job-postings.index')
            ->with('success', 'JobPosting wurde erfolgreich gelöscht.');
    }

    // Liefert alle Companies, die der aktuelle User auswählen darf.
    private function getSelectableCompaniesForUser(User $currentUser): Collection
    {
        // Admins dürfen alle Companies auswählen.
        if ($currentUser->role === 'admin') {
            return Company::orderBy('cmpny_name')->get();
        }

        // Andere User dürfen nur eigene Companies auswählen.
        return $currentUser->companies()
            ->orderBy('cmpny_name')
            ->get();
    }

    // Liefert eine konkrete Company, die der aktuelle User verwenden darf.
    private function findSelectableCompanyForUser(User $currentUser, int $companyId): Company
    {
        // Admins dürfen jede Company verwenden.
        if ($currentUser->role === 'admin') {
            return Company::where('id', $companyId)->firstOrFail();
        }

        // Andere User dürfen nur eigene Companies verwenden.
        return $currentUser->companies()
            ->where('id', $companyId)
            ->firstOrFail();
    }

    // Entfernt Fremdschlüssel aus den validierten JobPosting-Daten.
    private function getJobPostingDataWithoutForeignKeys(array $validatedJobPostingData): array
    {
        return [
            'title' => $validatedJobPostingData['title'],
            'jp_description' => $validatedJobPostingData['jp_description'] ?? null,
            'jp_location' => $validatedJobPostingData['jp_location'] ?? null,
            'experience_level' => $validatedJobPostingData['experience_level'] ?? null,
            'employment_type' => $validatedJobPostingData['employment_type'] ?? null,
            'salary' => $validatedJobPostingData['salary'] ?? null,
            'is_active' => $validatedJobPostingData['is_active'],
        ];
    }
}
