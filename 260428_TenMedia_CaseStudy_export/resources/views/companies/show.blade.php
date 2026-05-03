<x-app-layout>
    <x-slot name="title">
        Firma anzeigen
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Firma anzeigen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-6">
                        {{ $company->cmpny_name }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Firmen-Name
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $company->cmpny_name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Standort
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $company->cmpny_location ?? 'Keine Angabe' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Website
                            </p>

                            <p class="mt-1 text-gray-900">
                                @if ($company->website)
                                    <a
                                        href="{{ str_starts_with($company->website, 'http') ? $company->website : 'https://' . $company->website }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="text-blue-600 hover:underline"
                                    >
                                        {{ $company->website }}
                                    </a>
                                @else
                                    Keine Website
                                @endif
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Anzahl JobPostings
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $company->jobPostings->count() }}
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-700">
                                Beschreibung
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $company->cmpny_description ?? 'Keine Beschreibung' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        @can('update', $company)
                            <a
                                href="{{ route('companies.edit', $company) }}"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700"
                            >
                                Bearbeiten
                            </a>
                        @endcan

                        <a
                            href="{{ route('companies.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900"
                        >
                            Zurück zur Firmenliste
                        </a>

                        <a
                            href="{{ route('dashboard') }}"
                            class="text-sm text-gray-600 hover:text-gray-900"
                        >
                            Zurück zum Dashboard
                        </a>
                    </div>

                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">
                        Zugeordnete Provider
                    </h3>

                    @if ($company->providers->isEmpty())
                        <p>
                            Dieser Firma sind noch keine Provider zugeordnet.
                        </p>
                    @else
                        <table class="min-w-full border border-gray-300">
                            <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">
                                    Name
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    E-Mail
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Aktion
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($company->providers as $provider)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $provider->name }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $provider->email }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        <a
                                            href="{{ route('users.show', $provider) }}"
                                            class="text-blue-600 hover:underline"
                                        >
                                            Anzeigen
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">
                        Zugehörige JobPostings
                    </h3>

                    @if ($company->jobPostings->isEmpty())
                        <p>
                            Für diese Firma wurden noch keine JobPostings angelegt.
                        </p>
                    @else
                        <table class="min-w-full border border-gray-300">
                            <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">
                                    Titel
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Kategorie
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Standort
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Status
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Aktion
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($company->jobPostings as $jobPosting)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $jobPosting->title }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $jobPosting->category->ctgry_name ?? 'Keine Kategorie' }}
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
                                            class="text-blue-600 hover:underline"
                                        >
                                            Anzeigen
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
