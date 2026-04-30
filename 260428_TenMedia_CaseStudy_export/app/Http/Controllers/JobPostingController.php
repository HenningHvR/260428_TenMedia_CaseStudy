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
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class JobPostingController extends Controller
{
    private const ROLE_ADMIN = 'admin';

    // Zeigt eine Liste aller JobPostings an.
    public function index(): View
    {
        $this->authorize('viewAny', JobPosting::class);

        $jobPostings = JobPosting::with(['company', 'category'])
            ->latest()
            ->get();

        return view('job_postings.index', compact('jobPostings'));
    }

    // Zeigt das Formular zum Anlegen eines neuen JobPostings an.
    public function create(): View
    {
        $this->authorize('create', JobPosting::class);

        $currentUser = $this->getCurrentUser();

        $companies = $this->getSelectableCompaniesForUser($currentUser);

        $categories = Category::orderBy('ctgry_name')->get();

        return view('job_postings.create', compact('companies', 'categories'));
    }

    // Speichert ein neues JobPosting.
    public function store(StoreJobPostingRequest $request): RedirectResponse
    {
        $this->authorize('create', JobPosting::class);

        $validatedJobPostingData = $request->validated();

        $validatedJobPostingData['is_active'] = $request->boolean('is_active', true);

        $currentUser = $this->getCurrentUser();

        $company = $this->findSelectableCompanyForUser(
            $currentUser,
            (int) $validatedJobPostingData['company_id']
        );

        $category = Category::findOrFail($validatedJobPostingData['category_id']);

        $jobPostingDataWithoutForeignKeys = $this->getJobPostingDataWithoutForeignKeys($validatedJobPostingData);

        $jobPosting = new JobPosting($jobPostingDataWithoutForeignKeys);

        $jobPosting->category()->associate($category);

        $company->jobPostings()->save($jobPosting);

        return redirect()
            ->route('job-postings.index')
            ->with('success', 'JobPosting wurde erfolgreich erstellt.');
    }

    // Zeigt ein einzelnes JobPosting an.
    public function show(JobPosting $jobPosting): View
    {
        $this->authorize('view', $jobPosting);

        $jobPosting->load(['company', 'category']);

        return view('job_postings.show', compact('jobPosting'));
    }

    // Zeigt das Formular zum Bearbeiten eines JobPostings an.
    public function edit(JobPosting $jobPosting): View
    {
        $this->authorize('update', $jobPosting);

        $currentUser = $this->getCurrentUser();

        $companies = $this->getSelectableCompaniesForUser($currentUser);

        $categories = Category::orderBy('ctgry_name')->get();

        return view('job_postings.edit', compact('jobPosting', 'companies', 'categories'));
    }

    // Aktualisiert ein bestehendes JobPosting.
    public function update(UpdateJobPostingRequest $request, JobPosting $jobPosting): RedirectResponse
    {
        $this->authorize('update', $jobPosting);

        $validatedJobPostingData = $request->validated();

        $validatedJobPostingData['is_active'] = $request->boolean('is_active');

        $currentUser = $this->getCurrentUser();

        $company = $this->findSelectableCompanyForUser(
            $currentUser,
            (int) $validatedJobPostingData['company_id']
        );

        $category = Category::findOrFail($validatedJobPostingData['category_id']);

        $jobPostingDataWithoutForeignKeys = $this->getJobPostingDataWithoutForeignKeys($validatedJobPostingData);

        $jobPosting->update($jobPostingDataWithoutForeignKeys);

        $jobPosting->company()->associate($company);
        $jobPosting->category()->associate($category);

        $jobPosting->save();

        return redirect()
            ->route('job-postings.index')
            ->with('success', 'JobPosting wurde erfolgreich aktualisiert.');
    }

    // Löscht ein bestehendes JobPosting.
    public function destroy(JobPosting $jobPosting): RedirectResponse
    {
        $this->authorize('delete', $jobPosting);

        $jobPosting->delete();

        return redirect()
            ->route('job-postings.index')
            ->with('success', 'JobPosting wurde erfolgreich gelöscht.');
    }

    // Liefert den aktuell eingeloggten User.
    private function getCurrentUser(): User
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        return $currentUser;
    }

    // Liefert alle Companies, die der aktuelle User auswählen darf.
    private function getSelectableCompaniesForUser(User $currentUser): Collection
    {
        if ($this->isAdmin($currentUser)) {
            return Company::orderBy('cmpny_name')->get();
        }

        return $currentUser->companies()
            ->orderBy('cmpny_name')
            ->get();
    }

    // Liefert eine konkrete Company, die der aktuelle User verwenden darf.
    private function findSelectableCompanyForUser(User $currentUser, int $companyId): Company
    {
        if ($this->isAdmin($currentUser)) {
            return Company::where('id', $companyId)->firstOrFail();
        }

        return $currentUser->companies()
            ->where('id', $companyId)
            ->firstOrFail();
    }

    // Prüft, ob der aktuelle User Admin ist.
    private function isAdmin(User $currentUser): bool
    {
        return $currentUser->role === self::ROLE_ADMIN;
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
