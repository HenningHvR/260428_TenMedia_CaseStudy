<x-app-layout>
    <x-slot name="title">
        User bearbeiten
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User bearbeiten
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

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

            @if (auth()->id() === $user->id)
                <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded">
                    Die eigene Rolle kann nicht geändert werden.
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block font-medium text-sm text-gray-700">
                                Name
                            </label>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block font-medium text-sm text-gray-700">
                                E-Mail
                            </label>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block font-medium text-sm text-gray-700">
                                Neues Passwort
                            </label>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >

                            <p class="mt-1 text-sm text-gray-600">
                                Leer lassen, wenn das Passwort nicht geändert werden soll.
                            </p>

                            @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">
                                Neues Passwort bestätigen
                            </label>

                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            >
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block font-medium text-sm text-gray-700">
                                Rolle
                            </label>

                            @if (auth()->id() === $user->id)
                                <input
                                    type="hidden"
                                    name="role"
                                    value="{{ $user->role }}"
                                >
                            @endif

                            <select
                                id="role"
                                name="role"
                                required
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                @disabled(auth()->id() === $user->id)
                            >
                                <option
                                    value="admin"
                                    @selected(old('role', $user->role) === 'admin')
                                >
                                    admin
                                </option>

                                <option
                                    value="provider"
                                    @selected(old('role', $user->role) === 'provider')
                                >
                                    provider
                                </option>

                                <option
                                    value="applicant"
                                    @selected(old('role', $user->role) === 'applicant')
                                >
                                    applicant
                                </option>
                            </select>

                            @error('role')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <p class="text-sm text-gray-600">
                                Die User-Erstellung erfolgt über die Registrierung. In dieser Ansicht können bestehende User bearbeitet werden.
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <button
                                type="submit"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700"
                            >
                                Änderungen speichern
                            </button>

                            <a
                                href="{{ route('users.show', $user) }}"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Abbrechen
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
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
