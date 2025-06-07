<x-layouts.app :title="'Podgląd'">
    <main class="flex-grow">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-emerald-700">Szczegóły dania</h1>
                <p class="mt-2 text-sm text-gray-600">Podgląd danych wybranego dania</p>
            </div>

            <div class="bg-white shadow-xl rounded-2xl p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-emerald-800">{{ $menuItem->name }}</h2>

                    <div class="flex items-center space-x-2">
                        <div class="flex items-center text-yellow-400">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i <= round($menuItem->rating) ? '' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600">{{ number_format($menuItem->rating, 1) }} / 5</span>
                        <span class="text-sm text-gray-500">({{ $menuItem->rating_count }} ocen)</span>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-600"><strong class="text-gray-800">Opis:</strong>
                        {{ $menuItem->description ?? 'Brak' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600"><strong class="text-gray-800">Kategoria:</strong>
                        {{ $menuItem->category }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600"><strong class="text-gray-800">Cena:</strong>
                        {{ number_format($menuItem->price, 2) }} zł</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600"><strong class="text-gray-800">Restauracja:</strong>
                        {{ $menuItem->restaurant->name ?? 'Brak danych' }}</p>
                </div>

                <div class="pt-4">
                    <a href="#"
                       class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition duration-200 font-semibold shadow-sm">
                        Dodaj do koszyka
                    </a>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('items.index') }}"
                   class="inline-flex items-center text-emerald-700 hover:text-emerald-900 font-medium text-sm hover:underline transition">
                    ← Powrót do listy dań
                </a>
            </div>
        </div>
    </main>
</x-layouts.app>
