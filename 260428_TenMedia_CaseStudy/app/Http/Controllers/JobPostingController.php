<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobPosting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class JobPostingController extends Controller
{
    /**
     * Eine Liste der Ressource anzeigen.
     */
    public function index()
    {
        //
    }

    /**
     * Zeigt das Formular zum Anlegen einer neuen Ressource an.
     */
    public function create()
    {
        //
    }

    /**
     * Speicherung eines neuen JobPostings.
     */
    public function store(Request $request): RedirectResponse
    {
        /**
         * Validiert Eingabedaten aus dem Formular.
         */
        $validatedJobPostingData = $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'jp_description' => ['nullable', 'string'],
            'jp_location' => ['nullable', 'string', 'max:255'],
            'experience_level' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:255'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $validatedJobPostingData['is_active'] = $request->boolean('is_active', true);

        /**
         * Company, die dem aktuell eingeloggten User gehört.
         */
        $company = $request->user()
            ->companies()
            ->where('id', $validatedJobPostingData['company_id'])
            ->firstOrFail();

        /**
         * Category, die dem JobPosting zugeordnet werden soll.
         */
        $category = Category::findOrFail($validatedJobPostingData['category_id']);

        /**
         * Fachliche JobPosting-Daten ohne Fremdschlüssel.
         */
        $jobPostingDataWithoutForeignKeys = $this->getJobPostingDataWithoutForeignKeys($validatedJobPostingData);

        /**
         * Neues JobPosting-Objekt ohne company_id und category_id.
         */
        $jobPosting = new JobPosting($jobPostingDataWithoutForeignKeys);

        /**
         * Category wird über die Beziehung gesetzt.
         */
        $jobPosting->category()->associate($category);

        /**
         * Company wird über die Beziehung gesetzt und speichert das JobPosting.
         */
        $company->jobPostings()->save($jobPosting);

        return redirect()->route('job-postings.index');
    }

    /**
     * Zeigt die angegebene Ressource an.
     */
    public function show(JobPosting $jobPosting)
    {
        //
    }

    /**
     * Zeigt das Formular zum Bearbeiten der angegebenen Ressource an.
     */
    public function edit(JobPosting $jobPosting)
    {
        //
    }

    /**
     * Aktualisiert die angegebene Ressource im Speicher.
     */
    public function update(Request $request, JobPosting $jobPosting): RedirectResponse
    {
        $validatedJobPostingData = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'jp_description' => ['nullable', 'string'],
            'jp_location' => ['nullable', 'string', 'max:255'],
            'experience_level' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:255'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $validatedJobPostingData['is_active'] = $request->boolean('is_active');

        $category = Category::findOrFail($validatedJobPostingData['category_id']);

        $jobPostingDataWithoutForeignKeys = $this->getJobPostingDataWithoutForeignKeys($validatedJobPostingData);

        $jobPosting->update($jobPostingDataWithoutForeignKeys);

        $jobPosting->category()->associate($category);
        $jobPosting->save();

        return redirect()->route('job-postings.index');
    }

    /**
     * Entfernt die angegebene Ressource aus dem Speicher.
     */
    public function destroy(JobPosting $jobPosting): RedirectResponse
    {
        $jobPosting->delete();

        return redirect()->route('job-postings.index');
    }

    /**
     * Entfernt Fremdschlüssel aus den validierten JobPosting-Daten.
     */
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
