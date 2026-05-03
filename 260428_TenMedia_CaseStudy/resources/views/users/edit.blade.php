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
                            <p class="block font-medium text-sm text-gray-700">
                                Name
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $user->name }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <p class="block font-medium text-sm text-gray-700">
                                E-Mail
                            </p>

                            <p class="mt-1 text-gray-900">
                                {{ $user->email }}
                            </p>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block font-medium text-sm text-gray-700">
                                Rolle
                            </label>

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
                                Hinweis: Die User-Erstellung erfolgt über die Registrierung. In dieser Ansicht wird nur die Rolle eines bestehenden Users bearbeitet.
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <button
                                type="submit"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                @disabled(auth()->id() === $user->id)
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

                    @if ($user->role === 'provider')
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-lg font-semibold mb-4">
                                Company zuordnen
                            </h3>

                            @if ($companies->isEmpty())
                                <p class="text-sm text-gray-700">
                                    Es sind noch keine Companies vorhanden.
                                </p>
                            @else
                                <form method="POST" action="{{ route('users.assign-company', $user) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-4">
                                        <label for="company_id" class="block font-medium text-sm text-gray-700">
                                            Company auswählen
                                        </label>

                                        <select
                                            id="company_id"
                                            name="company_id"
                                            required
                                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                                        >
                                            <option value="">
                                                Bitte Company auswählen
                                            </option>

                                            @foreach ($companies as $company)
                                                <option
                                                    value="{{ $company->id }}"
                                                    @selected(old('company_id', $user->companies->first()?->id) == $company->id)
                                                >
                                                    {{ $company->cmpny_name }}
                                                    @if ($company->user)
                                                        | aktuell: {{ $company->user->name }} | {{ $company->user->email }}
                                                    @else
                                                        | aktuell: keine Zuordnung
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('company_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <button
                                            type="submit"
                                            class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700"
                                        >
                                            Company zuordnen
                                        </button>

                                        <a
                                            href="{{ route('users.show', $user) }}"
                                            class="text-sm text-gray-600 hover:text-gray-900"
                                        >
                                            Zur User-Detailseite
                                        </a>
                                    </div>
                                </form>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
