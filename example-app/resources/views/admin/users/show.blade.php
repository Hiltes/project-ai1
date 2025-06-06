<x-layouts.app :title="'Szczegóły użytkownika'">
    <main class="flex-grow">
        <div class="max-w-4xl mx-auto px-6 py-12">
            <h2 class="text-3xl font-bold text-emerald-700 mb-6">Szczegóły użytkownika</h2>

            <div class="bg-white shadow-md rounded-2xl p-8 space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Imię i nazwisko:</h3>
                    <p class="text-gray-900">{{ $user->name }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Email:</h3>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Rola:</h3>
                    <p class="text-gray-900">{{ $user->role }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Telefon:</h3>
                    <p class="text-gray-900">{{ $user->phone ?? 'Brak danych' }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Adres:</h3>
                    <p class="text-gray-900">{{ $user->address ?? 'Brak danych' }}</p>
                </div>

                <div class="pt-4">
                    <a href="{{ route('admin.users.edit', $user) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                        Edytuj użytkownika
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-emerald-500 rounded-xl shadow-sm text-sm font-medium text-emerald-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                        Wróć do listy użytkowników
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
