<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobPostingRequest;
use App\Http\Requests\UpdateJobPostingRequest;
use App\Models\Category;
use App\Models\JobPosting;
use Illuminate\Http\RedirectResponse;

class JobPostingController extends Controller
{
    // Zeigt eine Liste aller JobPostings an.
    public function index()
    {
        $this->authorize('viewAny', JobPosting::class);

        // Lädt JobPostings inklusive zugehöriger Company und Category.
        $jobPostings = JobPosting::with(['company', 'category'])
            ->latest()
            ->get();

        return view('job_postings.index', compact('jobPostings'));
    }

    // Zeigt das Formular zum Anlegen eines neuen JobPostings an.
    public function create()
    {
        $this->authorize('create', JobPosting::class);

        // Lädt nur die Companies des aktuell eingeloggten Users.
        $companies = auth()->user()->companies;

        // Lädt alle verfügbaren Kategorien.
        $categories = Category::all();

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

        // Lädt nur eine Company, die dem aktuell eingeloggten User gehört.
        $company = $request->user()
            ->companies()
            ->where('id', $validatedJobPostingData['company_id'])
            ->firstOrFail();

        // Lädt die zugehörige Category.
        $category = Category::findOrFail($validatedJobPostingData['category_id']);

        // Entfernt Fremdschlüssel aus den Mass-Assignment-Daten.
        $jobPostingDataWithoutForeignKeys = $this->getJobPostingDataWithoutForeignKeys($validatedJobPostingData);

        // Erstellt ein neues JobPosting ohne direkte Fremdschlüssel-Zuweisung.
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
    public function show(JobPosting $jobPosting)
    {
        $this->authorize('view', $jobPosting);

        // Lädt die zugehörigen Beziehungen für die Detailansicht.
        $jobPosting->load(['company', 'category']);

        return view('job_postings.show', compact('jobPosting'));
    }

    // Zeigt das Formular zum Bearbeiten eines JobPostings an.
    public function edit(JobPosting $jobPosting)
    {
        $this->authorize('update', $jobPosting);

        // Lädt nur die Companies des aktuell eingeloggten Users.
        $companies = auth()->user()->companies;

        // Lädt alle verfügbaren Kategorien.
        $categories = Category::all();

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

        // Lädt die neu gewählte Category.
        $category = Category::findOrFail($validatedJobPostingData['category_id']);

        // Entfernt Fremdschlüssel aus den Mass-Assignment-Daten.
        $jobPostingDataWithoutForeignKeys = $this->getJobPostingDataWithoutForeignKeys($validatedJobPostingData);

        // Aktualisiert die normalen Attribute des JobPostings.
        $jobPosting->update($jobPostingDataWithoutForeignKeys);

        // Aktualisiert die Category-Zuordnung.
        $jobPosting->category()->associate($category);

        // Speichert die geänderte Category-Zuordnung.
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
