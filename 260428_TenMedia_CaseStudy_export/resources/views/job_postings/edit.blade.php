<x-app-layout>
    <x-slot name="title">
        JobPosting bearbeiten
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            JobPosting bearbeiten
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('job-postings.update', $jobPosting) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="company_id" class="block font-medium text-sm text-gray-700">
                                Firma
                            </label>

                            <select
                                id="company_id"
                                name="company_id"
                                required
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >
                                <option value="">Bitte Firma auswählen</option>

                                @foreach ($companies as $company)
                                    <option
                                        value="{{ $company->id }}"
                                        @selected(old('company_id', $jobPosting->company_id) == $company->id)
                                    >
                                        {{ $company->cmpny_name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('company_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="block font-medium text-sm text-gray-700">
                                Kategorie
                            </label>

                            <select
                                id="category_id"
                                name="category_id"
                                required
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >
                                <option value="">Bitte Kategorie auswählen</option>

                                @foreach ($categories as $category)
                                    <option
                                        value="{{ $category->id }}"
                                        @selected(old('category_id', $jobPosting->category_id) == $category->id)
                                    >
                                        {{ $category->ctgry_name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="title" class="block font-medium text-sm text-gray-700">
                                Titel
                            </label>

                            <input
                                id="title"
                                name="title"
                                type="text"
                                value="{{ old('title', $jobPosting->title) }}"
                                required
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jp_description" class="block font-medium text-sm text-gray-700">
                                Beschreibung
                            </label>

                            <textarea
                                id="jp_description"
                                name="jp_description"
                                rows="4"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >{{ old('jp_description', $jobPosting->jp_description) }}</textarea>

                            @error('jp_description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="jp_location" class="block font-medium text-sm text-gray-700">
                                Ort
                            </label>

                            <input
                                id="jp_location"
                                name="jp_location"
                                type="text"
                                value="{{ old('jp_location', $jobPosting->jp_location) }}"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('jp_location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="experience_level" class="block font-medium text-sm text-gray-700">
                                Erfahrungslevel
                            </label>

                            <input
                                id="experience_level"
                                name="experience_level"
                                type="text"
                                value="{{ old('experience_level', $jobPosting->experience_level) }}"
                                placeholder="z. B. Junior, Professional, Senior"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('experience_level')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="employment_type" class="block font-medium text-sm text-gray-700">
                                Arbeitszeit
                            </label>

                            <input
                                id="employment_type"
                                name="employment_type"
                                type="text"
                                value="{{ old('employment_type', $jobPosting->employment_type) }}"
                                placeholder="Vollzeit, Teilzeit (Stunden)"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('employment_type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="salary" class="block font-medium text-sm text-gray-700">
                                Gehalt
                            </label>

                            <input
                                id="salary"
                                name="salary"
                                type="number"
                                min="0"
                                step="0.01"
                                value="{{ old('salary', $jobPosting->salary) }}"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('salary')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <input
                                type="hidden"
                                name="is_active"
                                value="0"
                            >

                            <label class="inline-flex items-center">
                                <input
                                    id="is_active"
                                    name="is_active"
                                    type="checkbox"
                                    value="1"
                                    @checked(old('is_active', $jobPosting->is_active) == '1')
                                    class="rounded border-gray-300 text-gray-800 shadow-sm"
                                >

                                <span class="ml-2 text-sm text-gray-700">
                                    JobPosting ist aktiv
                                </span>
                            </label>

                            @error('is_active')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button
                                type="submit"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700"
                            >
                                Änderungen speichern
                            </button>

                            <a
                                href="{{ route('job-postings.show', $jobPosting) }}"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Abbrechen
                            </a>

                            <a
                                href="{{ route('job-postings.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Zurück zur Übersicht
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

