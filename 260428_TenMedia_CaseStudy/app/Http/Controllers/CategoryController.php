<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    // Zeigt eine Liste aller Kategorien an.
    public function index(): View
    {
        // Enthält alle Kategorien inklusive Anzahl der zugehörigen JobPostings.
        $categories = Category::withCount('jobPostings')
            ->orderBy('ctgry_name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    // Zeigt das Formular zum Anlegen einer neuen Kategorie an.
    public function create(): View
    {
        return view('categories.create');
    }

    // Speichert eine neue Kategorie.
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        // Enthält die geprüften Formulardaten.
        $validatedCategoryData = $request->validated();

        Category::create($validatedCategoryData);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategorie wurde erfolgreich erstellt.');
    }

    // Zeigt eine einzelne Kategorie an.
    public function show(Category $category): View
    {
        // Lädt alle JobPostings inkl. Company, die dieser Kategorie zugeordnet sind.
        $category->load('jobPostings.company');

        return view('categories.show', compact('category'));
    }

    // Zeigt das Formular zum Bearbeiten einer Kategorie an.
    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    // Aktualisiert eine bestehende Kategorie.
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        // Enthält die geprüften Formulardaten.
        $validatedCategoryData = $request->validated();

        $category->update($validatedCategoryData);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategorie wurde erfolgreich aktualisiert.');
    }

    // Löscht eine bestehende Kategorie.
    public function destroy(Category $category): RedirectResponse
    {
        // Prüft, ob noch JobPostings mit dieser Kategorie verbunden sind.
        if ($category->jobPostings()->exists()) {
            return redirect()
                ->route('categories.show', $category)
                ->with('error', 'Diese Kategorie kann nicht gelöscht werden, weil noch JobPostings zugeordnet sind.');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategorie wurde erfolgreich gelöscht.');
    }
}
