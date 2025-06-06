<x-layouts.app :title="'Lista Dań'">

    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="sm:flex sm:items-center sm:justify-between mb-8">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-bold text-emerald-700">Zarządzanie daniami</h1>
                    <p class="mt-2 text-sm text-gray-600">Lista wszystkich dostępnych dań w systemie</p>
                </div>
                <a href="{{ route('admin.menu_items.create') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Dodaj nowe danie
                </a>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-2xl">

                <div class="border-b border-gray-100 px-6 py-4">
                    <form method="GET" action="{{ route('admin.menu_items.index') }}">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <div class="flex-1">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Wyszukaj danie..."
                                    class="w-full px-4 py-2 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition duration-200">
                            </div>
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
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <a href="{{ route('admin.menu_items.show', $item) }}"
                                        class="text-lg font-semibold text-emerald-700 hover:text-emerald-900 hover:underline">
                                        {{ $item->name }}
                                    </a>
                                    <p class="text-base text-gray-600 mt-1">{{ $item->description ?: 'Brak opisu' }}</p>
                                </div>
                            </div>
                        </div>


                        <div class="col-span-3 md:col-span-2 text-right font-medium text-gray-900">
                            {{ number_format($item->price, 2) }} zł
                        </div>

                        <div class="hidden md:col-span-4 md:block">
                            <div class="flex items-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $item->restaurant->name ?? 'Brak danych' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-span-4 md:col-span-2">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.menu_items.edit', $item) }}" style="background-color: #1fa37a;"
                                    class="inline-flex items-center px-3 py-1 border border-white-300 shadow-sm text-sm leading-4 font-medium rounded-xl text-white bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                                    Edytuj
                                </a>
                                <form action="{{ route('admin.menu_items.destroy', $item) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-xl shadow-sm text-grey focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all"
                                        onclick="return confirm('Czy na pewno chcesz usunąć to danie?')">
                                        Usuń
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Brak dań</h3>
                        <p class="mt-1 text-sm text-gray-500">Nie dodano jeszcze żadnych dań do systemu.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.menu_items.create') }}" style="background-color: #1fa37a;"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                Dodaj nowe danie
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Paginacja -->
            @if ($items->hasPages())
                <div class="mt-6 px-4 sm:px-0">
                    {{ $items->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </main>

</x-layouts.app>
