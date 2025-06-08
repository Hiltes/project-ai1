<x-layouts.app :title="'Lista Restauracji'">
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="sm:flex sm:items-center sm:justify-between mb-8">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-bold text-emerald-700">Przeglądaj restauracje</h1>
                    <p class="mt-2 text-sm text-gray-600">Lista wszystkich restauracji dostępnych w systemie</p>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-2xl">
                <div class="border-b border-gray-100 px-6 py-4">
                    <form method="GET" action="{{ route('restaurants.index') }}">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Wyszukaj restaurację..."
                                class="flex-1 px-4 py-2 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition duration-200">

                            <select name="type"
                                class="px-4 py-2 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition duration-200">
                                <option value="">-- wszystkie typy --</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}" {{ $selectedType === $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="sort"
                                class="px-4 py-2 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none transition duration-200">
                                <option value="">-- sortuj --</option>
                                <option value="name_asc" {{ $selectedSort === 'name_asc' ? 'selected' : '' }}>Nazwa A-Z</option>
                                <option value="name_desc" {{ $selectedSort === 'name_desc' ? 'selected' : '' }}>Nazwa Z-A</option>
                                <option value="rating" {{ $selectedSort === 'rating' ? 'selected' : '' }}>Najlepiej oceniane</option>
                            </select>

                            <button type="submit"
                                class="px-6 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition duration-200">
                                Filtruj
                            </button>
                        </div>
                    </form>
                </div>

                <ul class="divide-y divide-gray-100">
                    @forelse ($restaurants as $restaurant)
                        <li class="px-6 py-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-emerald-600">{{ $restaurant->name }}</h3>

                                    <p class="text-sm text-gray-500">{{ $restaurant->type }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-sm text-yellow-600 flex items-center gap-1">
                                        @php
                                            $avg = round($restaurant->reviews_avg_rating ?? 0, 1);
                                            $fullStars = floor($avg);
                                            $hasHalfStar = $avg - $fullStars >= 0.5;
                                        @endphp

                                        {{-- Gwiazdki pełne --}}
                                        @for ($i = 0; $i < $fullStars; $i++)
                                            ★
                                        @endfor

                                        {{-- Gwiazdka połówkowa --}}
                                        @if ($hasHalfStar)
                                            ☆
                                        @endif

                                        {{-- Puste gwiazdki --}}
                                        @for ($i = $fullStars + ($hasHalfStar ? 1 : 0); $i < 5; $i++)
                                            ☆
                                        @endfor

                                        <span class="text-gray-700 ml-2">
                                          {{ $avg }} / 5 ({{ $restaurant->reviews_count }} opini{{ $restaurant->reviews_count === 1 ? 'a' : ($restaurant->reviews_count === 0 ? 'i' : 'e') }})

                                        </span>
                                    </div>

                                    <a href="{{ url('/restaurant/' . $restaurant->id) }}"
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm rounded-xl hover:bg-emerald-700 transition duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        Zobacz
                                    </a>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-4 text-gray-500">Brak wyników.</li>
                    @endforelse
                </ul>

                <div class="px-6 py-4">
                    {{ $restaurants->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
