<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            JobPostings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('job-postings.create') }}"
                   class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Neues JobPosting anlegen
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($jobPostings->isEmpty())
                        <p>Es wurden noch keine JobPostings angelegt.</p>
                    @else
                        <table class="min-w-full border border-gray-300">
                            <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">Titel</th>
                                <th class="border px-4 py-2 text-left">Company</th>
                                <th class="border px-4 py-2 text-left">Kategorie</th>
                                <th class="border px-4 py-2 text-left">Ort</th>
                                <th class="border px-4 py-2 text-left">Status</th>
                                <th class="border px-4 py-2 text-left">Aktionen</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($jobPostings as $jobPosting)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $jobPosting->title }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $jobPosting->company->cmpny_name ?? 'Keine Company' }}
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
                                        <a href="{{ route('job-postings.show', $jobPosting) }}"
                                           class="text-blue-600 hover:underline">
                                            Anzeigen
                                        </a>

                                        <span class="mx-1">|</span>

                                        <a href="{{ route('job-postings.edit', $jobPosting) }}"
                                           class="text-blue-600 hover:underline">
                                            Bearbeiten
                                        </a>

                                        <span class="mx-1">|</span>

                                        <form action="{{ route('job-postings.destroy', $jobPosting) }}"
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="text-red-600 hover:underline"
                                                    onclick="return confirm('Dieses JobPosting wirklich löschen?')">
                                                Löschen
                                            </button>
                                        </form>
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
