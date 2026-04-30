<x-app-layout>
    <x-slot name="title">
        JobPosting anzeigen
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            JobPosting anzeigen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">
                            {{ $jobPosting->title }}
                        </h3>

                        <p class="mt-2 text-gray-700">
                            {{ $jobPosting->jp_description ?? 'Keine Beschreibung hinterlegt.' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Firma</p>

                            <p class="mt-1 text-gray-900">
                                @if ($jobPosting->company)
                                    <a
                                        href="{{ route('companies.show', $jobPosting->company) }}"
                                        class="text-blue-600 hover:underline"
                                    >
                                        {{ $jobPosting->company->cmpny_name }}
                                    </a>
                                @else
                                    Keine Firma zugeordnet
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Kategorie</p>

                            <p class="mt-1 text-gray-900">
                                @if ($jobPosting->category)
                                    <a
                                        href="{{ route('categories.show', $jobPosting->category) }}"
                                        class="text-blue-600 hover:underline"
                                    >
                                        {{ $jobPosting->category->ctgry_name }}
                                    </a>
                                @else
                                    Keine Kategorie zugeordnet
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Ort</p>

                            <p class="mt-1 text-gray-900">
                                {{ $jobPosting->jp_location ?? 'Keine Angabe' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Erfahrungslevel</p>

                            <p class="mt-1 text-gray-900">
                                {{ $jobPosting->experience_level ?? 'Keine Angabe' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Arbeitszeit</p>

                            <p class="mt-1 text-gray-900">
                                {{ $jobPosting->employment_type ?? 'Keine Angabe' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Gehalt</p>

                            <p class="mt-1 text-gray-900 whitespace-nowrap">
                                @if ($jobPosting->salary)
                                    {{ number_format($jobPosting->salary, 0, ',', '.') }}&nbsp;€
                                @else
                                    Keine Angabe
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Status</p>

                            <p class="mt-1 text-gray-900">
                                @if ($jobPosting->is_active)
                                    Aktiv
                                @else
                                    Inaktiv
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Erstellt am</p>

                            <p class="mt-1 text-gray-900">
                                {{ $jobPosting->created_at?->format('d.m.Y H:i') ?? 'Keine Angabe' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Zuletzt geändert am</p>

                            <p class="mt-1 text-gray-900">
                                {{ $jobPosting->updated_at?->format('d.m.Y H:i') ?? 'Keine Angabe' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        @can('update', $jobPosting)
                            <a
                                href="{{ route('job-postings.edit', $jobPosting) }}"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700"
                            >
                                Bearbeiten
                            </a>
                        @endcan

                        @can('delete', $jobPosting)
                            <form
                                method="POST"
                                action="{{ route('job-postings.destroy', $jobPosting) }}"
                                onsubmit="return confirm('Dieses JobPosting wirklich löschen?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-red-700 text-white rounded-md hover:bg-red-600"
                                >
                                    Löschen
                                </button>
                            </form>
                        @endcan

                        <a
                            href="{{ route('job-postings.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900"
                        >
                            Zurück zur Übersicht
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
