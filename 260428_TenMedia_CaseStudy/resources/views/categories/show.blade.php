<x-app-layout>
    <x-slot name="title">
        Kategorie anzeigen
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategorie anzeigen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex items-center gap-4">
                <a
                    href="{{ route('categories.index') }}"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    Zurück zur Übersicht
                </a>

                <a
                    href="{{ route('categories.edit', $category) }}"
                    class="text-sm text-blue-600 hover:text-blue-900"
                >
                    Kategorie bearbeiten
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">
                        {{ $category->ctgry_name }}
                    </h3>

                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-700">
                            Beschreibung
                        </p>

                        <p class="mt-1 text-gray-900">
                            {{ $category->ctgry_description ?? 'Keine Beschreibung hinterlegt.' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Erstellt am
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $category->created_at?->format('d.m.Y H:i') ?? 'Keine Angabe' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Zuletzt geändert am
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $category->updated_at?->format('d.m.Y H:i') ?? 'Keine Angabe' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">
                        Zugeordnete JobPostings
                    </h3>

                    @if ($category->jobPostings->isEmpty())
                        <p>
                            Dieser Kategorie sind noch keine JobPostings zugeordnet.
                        </p>
                    @else
                        <table class="min-w-full border border-gray-300">
                            <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">Titel</th>
                                <th class="border px-4 py-2 text-left">Company</th>
                                <th class="border px-4 py-2 text-left">Ort</th>
                                <th class="border px-4 py-2 text-left">Status</th>
                                <th class="border px-4 py-2 text-left">Aktion</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($category->jobPostings as $jobPosting)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $jobPosting->title }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $jobPosting->company->cmpny_name ?? 'Keine Company' }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $jobPosting->jp_location ?? 'Keine Angabe' }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        @if ($jobPosting->is_active)
                                            Aktiv
                                        @else
                                            Inaktiv
                                        @endif
                                    </td>

                                    <td class="border px-4 py-2">
                                        <a
                                            href="{{ route('job-postings.show', $jobPosting) }}"
                                            class="text-blue-600 hover:text-blue-900"
                                        >
                                            JobPosting anzeigen
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
