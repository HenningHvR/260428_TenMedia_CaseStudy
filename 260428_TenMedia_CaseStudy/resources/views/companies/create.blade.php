<x-app-layout>
    <x-slot name="title">
        Firma erstellen
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Firma erstellen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('companies.store') }}">
                        @csrf

                        <fieldset class="mb-4">
                            <legend class="block font-medium text-sm text-gray-700">
                                Provider
                            </legend>

                            <div class="mt-2 space-y-2">
                                @foreach ($providers as $provider)
                                    <label class="flex items-center gap-2">
                                        <input
                                            type="radio"
                                            name="user_id"
                                            value="{{ $provider->id }}"
                                            required
                                            @checked(old('user_id') == $provider->id)
                                            class="border-gray-300 text-gray-800 shadow-sm"
                                        >

                                        <span class="text-sm text-gray-700">
                                            {{ $provider->name }} | {{ $provider->email }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            @error('user_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </fieldset>

                        <div class="mb-4">
                            <label for="cmpny_name" class="block font-medium text-sm text-gray-700">
                                Firmen-Name
                            </label>

                            <input
                                id="cmpny_name"
                                name="cmpny_name"
                                type="text"
                                value="{{ old('cmpny_name') }}"
                                required
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('cmpny_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cmpny_description" class="block font-medium text-sm text-gray-700">
                                Beschreibung
                            </label>

                            <textarea
                                id="cmpny_description"
                                name="cmpny_description"
                                rows="4"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >{{ old('cmpny_description') }}</textarea>

                            @error('cmpny_description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="website" class="block font-medium text-sm text-gray-700">
                                URL
                            </label>

                            <input
                                id="website"
                                name="website"
                                type="text"
                                inputmode="url"
                                value="{{ old('website') }}"
                                placeholder="www.beispiel.de"
                                pattern="^(https?://www\.|www\.).+"
                                title="Die URL muss mit https://www., http://www. oder www. beginnen."
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('website')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cmpny_location" class="block font-medium text-sm text-gray-700">
                                Standort
                            </label>

                            <input
                                id="cmpny_location"
                                name="cmpny_location"
                                type="text"
                                value="{{ old('cmpny_location') }}"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('cmpny_location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <button
                                type="submit"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700"
                            >
                                Speichern
                            </button>

                            <a
                                href="{{ route('companies.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Abbrechen
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
