<x-layouts.app :title="'Podgląd'">

    <main class="flex-grow">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Nagłówek sekcji -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-emerald-700">Szczegóły dania</h1>
            <p class="mt-2 text-sm text-gray-600">Podgląd danych wybranego dania</p>
        </div>

        <!-- Karta szczegółów -->
        <div class="bg-white shadow rounded-2xl p-6 space-y-6">
            <div>
                <h2 class="text-2xl font-semibold text-emerald-800">{{ $menuItem->name }}</h2>
            </div>

            <div>
                <p class="text-sm text-gray-600"><strong class="text-gray-800">Opis:</strong>
                    {{ $menuItem->description ?? 'Brak' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-600"><strong class="text-gray-800">Cena:</strong>
                    {{ number_format($menuItem->price, 2) }} zł</p>
            </div>

            <div>
                <p class="text-sm text-gray-600"><strong class="text-gray-800">Restauracja:</strong>
                    {{ $menuItem->restaurant->name ?? 'Brak danych' }}</p>
            </div>
        </div>

        <!-- Powrót -->
        <div class="mt-6">
            <a href="{{ route('admin.menu_items.index') }}"
                class="inline-flex items-center text-emerald-700 hover:text-emerald-900 font-medium text-sm hover:underline transition">
                ← Powrót do listy dań
            </a>
        </div>

    </div>
</main>

</x-layouts.app>
