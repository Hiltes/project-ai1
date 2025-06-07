<x-layouts.app :title="'Lista Dań'">
    <main class="flex-grow">

        <div class="bg-white shadow sm:rounded-2xl overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="sm:flex sm:items-center sm:justify-between mb-8">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-3xl font-bold text-emerald-700">Zarządzanie daniami</h1>
                        <p class="mt-2 text-sm text-gray-600">Lista wszystkich dostępnych dań w systemie</p>
                    </div>
                    <a href="{{ route('admin.menu_items.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Dodaj nowe danie
                    </a>
                </div>

                <div class="bg-white shadow overflow-hidden sm:rounded-2xl">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <form method="GET" action="{{ route('admin.menu_items.index') }}">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Wyszukaj danie..."
                                    class="flex-1 px-4 py-2 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition duration-200">
                                <select name="category"
                                    class="px-4 py-2 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition duration-200">
                                    <option value="">-- wszystkie kategorie --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat }}"
                                            {{ $selectedCategory === $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                    class="inline-flex justify-center items-center px-6 py-2 rounded-xl bg-emerald-600 text-white font-medium shadow hover:bg-emerald-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                    Szukaj
                                </button>
                            </div>
                        </form>
                    </div>

                    @forelse($items as $item)
                        <div
                            class="grid grid-cols-12 gap-4 px-6 py-4 items-center border-b border-gray-100 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="col-span-5 md:col-span-4">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-6 w-6 text-emerald-600" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('admin.menu_items.show', $item) }}"
                                            class="text-lg font-semibold text-emerald-700 hover:text-emerald-900 hover:underline">
                                            {{ $item->name }}
                                        </a>
                                        <p class="text-base text-gray-600 mt-1">
                                            {{ \Illuminate\Support\Str::words(strip_tags($item->description), 20, ' [...]') ?: 'Brak opisu' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2 text-sm text-gray-700">
                                <span class="inline-block px-2 py-1 rounded-full bg-gray-100 text-gray-800">
                                    {{ $item->category }}
                                </span>
                            </div>

                            <div class="col-span-2 text-right font-medium text-gray-900">
                                {{ number_format($item->price, 2) }} zł
                            </div>

                            <div class="hidden md:col-span-2 md:block text-sm">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $item->restaurant->name ?? 'Brak danych' }}
                                </span>
                            </div>

                            <a href="{{ route('admin.menu_items.edit', $item) }}"
                                class="inline-flex items-center text-justify px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition duration-200">
                                Edytuj
                            </a>
                            <form action="{{ route('admin.menu_items.destroy', $item) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Czy na pewno chcesz usunąć to danie?')"
                                    class="inline-flex items-center px-4 py-2 rounded-xl bg-red-600 text-white hover:bg-red-700 transition duration-200">
                                    Usuń
                                </button>
                            </form>

                        </div>



                    @empty
                        <div class="px-6 py-12 text-center">
                            <svg class="mx-auto h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Brak dań</h3>
                            <p class="mt-1 text-sm text-gray-500">Nie dodano jeszcze żadnych dań do systemu.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.menu_items.create') }}"
                                    class="inline-flex items-center px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 transition duration-200">
                                    Dodaj nowe danie
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>


                @if ($items->hasPages())
                    <div class="mt-6 flex justify-center">
                        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center space-x-2">
                            @if ($items->onFirstPage())
                                <span
                                    class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">←
                                    Poprzednia</span>
                            @else
                                <a href="{{ $items->previousPageUrl() }}"
                                    class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition">
                                    ← Poprzednia
                                </a>
                            @endif

                            @foreach ($items->links()->elements[0] as $page => $url)
                                @if ($page == $items->currentPage())
                                    <span
                                        class="px-4 py-2 text-sm font-semibold text-emerald-700 bg-emerald-100 rounded-xl">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-xl transition">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($items->hasMorePages())
                                <a href="{{ $items->nextPageUrl() }}"
                                    class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition">
                                    Następna →
                                </a>
                            @else
                                <span
                                    class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">Następna
                                    →</span>
                            @endif
                        </nav>
                    </div>
                @endif

            </div>
    </main>
</x-layouts.app>
