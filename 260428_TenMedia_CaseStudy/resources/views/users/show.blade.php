<x-app-layout>
    <x-slot name="title">
        User anzeigen
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User anzeigen
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
                        {{ $user->name }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Name
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $user->name }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                E-Mail
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $user->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Rolle
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $user->role }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Firma
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $user->company?->cmpny_name ?? 'Keine Firma' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Anzahl JobPostings
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $user->jobPostings->count() }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Erstellt am
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $user->created_at?->format('d.m.Y H:i') ?? 'Keine Angabe' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">
                                Zuletzt geändert am
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $user->updated_at?->format('d.m.Y H:i') ?? 'Keine Angabe' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <a
                            href="{{ route('users.edit', $user) }}"
                            class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700"
                        >
                            Bearbeiten
                        </a>

                        <a
                            href="{{ route('users.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-900"
                        >
                            Zurück zur Userliste
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-semibold mb-4">
                        Zugehörige JobPostings
                    </h3>

                    @if ($user->jobPostings->isEmpty())
                        <p>
                            Diesem User sind noch keine JobPostings zugeordnet.
                        </p>
                    @else
                        <table class="min-w-full border border-gray-300">
                            <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">
                                    Titel
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Firma
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
                            @foreach ($user->jobPostings as $jobPosting)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $jobPosting->title }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $jobPosting->company->cmpny_name ?? 'Keine Firma' }}
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
