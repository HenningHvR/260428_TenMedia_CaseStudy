<x-app-layout>
    <x-slot name="title">
        Firmen anzeigen
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Firmen anzeigen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            <div class="mb-4 flex items-center gap-4">
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700"
                >
                    Zurück zum Dashboard
                </a>

                @can('create', App\Models\Company::class)
                    <a
                        href="{{ route('companies.create') }}"
                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Neue Firma anlegen
                    </a>
                @endcan
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($companies->isEmpty())
                        <p>
                            Es wurden noch keine Firmen angelegt.
                        </p>
                    @else
                        <table class="min-w-full border border-gray-300">
                            <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">
                                    Firma
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Beschreibung
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Website
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Standort
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Provider
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    JobPostings
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Aktionen
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($companies as $company)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $company->cmpny_name }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $company->cmpny_description ?? 'Keine Beschreibung' }}
                                    </td>

                                    <td class="border px-4 py-2">
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
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $company->cmpny_location ?? 'Keine Angabe' }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        @if ($company->providers->isEmpty())
                                            Keine Provider
                                        @else
                                            {{ $company->providers->pluck('name')->join(', ') }}
                                        @endif
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $company->job_postings_count }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        <a
                                            href="{{ route('companies.show', $company) }}"
                                            class="text-blue-600 hover:underline"
                                        >
                                            Anzeigen
                                        </a>

                                        @can('update', $company)
                                            <span class="mx-1">|</span>

                                            <a
                                                href="{{ route('companies.edit', $company) }}"
                                                class="text-blue-600 hover:underline"
                                            >
                                                Bearbeiten
                                            </a>
                                        @endcan

                                        @can('delete', $company)
                                            @if ($company->job_postings_count === 0 && $company->providers->isEmpty())
                                                <span class="mx-1">|</span>

                                                <form
                                                    action="{{ route('companies.destroy', $company) }}"
                                                    method="POST"
                                                    class="inline"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="text-red-600 hover:underline"
                                                        onclick="return confirm('Diese Firma wirklich löschen?')"
                                                    >
                                                        Löschen
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
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
