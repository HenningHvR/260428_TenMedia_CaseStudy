<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                <a
                    href="{{ route('categories.index') }}"
                    class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 transition"
                >
                    <div class="p-6 text-center text-gray-900 font-semibold text-lg">
                        Kategorien
                    </div>
                </a>

                <a
                    href="{{ route('companies.index') }}"
                    class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 transition"
                >
                    <div class="p-6 text-center text-gray-900 font-semibold text-lg">
                        Firmen
                    </div>
                </a>

                <a
                    href="{{ route('job-postings.index') }}"
                    class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 transition"
                >
                    <div class="p-6 text-center text-gray-900 font-semibold text-lg">
                        JobPostings
                    </div>
                </a>

                @can('viewAny', \App\Models\User::class)
                    <a
                        href="{{ route('users.index') }}"
                        class="block bg-white overflow-hidden shadow-sm sm:rounded-lg hover:bg-gray-50 transition"
                    >
                        <div class="p-6 text-center text-gray-900 font-semibold text-lg">
                            User
                        </div>
                    </a>
                @endcan

            </div>

        </div>
    </div>
</x-app-layout>
