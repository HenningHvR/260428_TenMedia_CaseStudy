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

            <div class="mb-4">
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700"
                >
                    Zurück zum Dashboard
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($users->isEmpty())
                        <p>
                            Es wurden noch keine User angelegt.
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
                                    Rolle
                                </th>

                                <th class="border px-4 py-2 text-left">
                                    Firma
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
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border px-4 py-2">
                                        {{ $user->name }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $user->email }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $user->role }}
                                    </td>
                                    
                                    <td class="border px-4 py-2">
                                        @if ($user->companies->isEmpty())
                                            Keine Firma
                                        @else
                                            {{ $user->companies->pluck('cmpny_name')->join(', ') }}
                                        @endif
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $user->job_postings_count }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        <a
                                            href="{{ route('users.show', $user) }}"
                                            class="text-blue-600 hover:underline"
                                        >
                                            Anzeigen
                                        </a>

                                        <span class="mx-1">|</span>

                                        <a
                                            href="{{ route('users.edit', $user) }}"
                                            class="text-blue-600 hover:underline"
                                        >
                                            Bearbeiten
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
