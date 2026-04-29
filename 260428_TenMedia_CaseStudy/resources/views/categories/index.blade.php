<x-app-layout>
    <x-slot name="title">
        Kategorie
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategorien
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
                <a href="{{ route('categories.create') }}"
                   class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Neue Kategorie anlegen
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($categories->isEmpty())
                        <p>Es wurden noch keine Kategorien angelegt.</p>
                    @else
                        <table class="min-w-full border border-gray-300">
                            <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2 text-left">Name</th>
                                <th class="border px-4 py-2 text-left">Beschreibung</th>
                                <th class="border px-4 py-2 text-left">JobPostings</th>
                                <th class="border px-4 py-2 text-left">Aktionen</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $category->ctgry_name }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $category->ctgry_description ?? 'Keine Beschreibung' }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $category->job_postings_count }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        <a href="{{ route('categories.show', $category) }}"
                                           class="text-blue-600 hover:underline">
                                            Anzeigen
                                        </a>

                                        <span class="mx-1">|</span>

                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="text-blue-600 hover:underline">
                                            Bearbeiten
                                        </a>

                                        <span class="mx-1">|</span>

                                        <form action="{{ route('categories.destroy', $category) }}"
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="text-red-600 hover:underline"
                                                    onclick="return confirm('Diese Kategorie wirklich löschen?')">
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
