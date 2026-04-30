<x-app-layout>
    <x-slot name="title">
        Kategorie bearbeiten
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kategorie bearbeiten
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('categories.update', $category) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="ctgry_name" class="block font-medium text-sm text-gray-700">
                                Kategoriename
                            </label>

                            <input
                                id="ctgry_name"
                                name="ctgry_name"
                                type="text"
                                value="{{ old('ctgry_name', $category->ctgry_name) }}"
                                required
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('ctgry_name')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="ctgry_description" class="block font-medium text-sm text-gray-700">
                                Beschreibung
                            </label>

                            <textarea
                                id="ctgry_description"
                                name="ctgry_description"
                                rows="4"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >{{ old('ctgry_description', $category->ctgry_description) }}</textarea>

                            @error('ctgry_description')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
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
                                href="{{ route('categories.show', $category) }}"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Abbrechen
                            </a>

                            <a
                                href="{{ route('categories.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Zur Übersicht
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
