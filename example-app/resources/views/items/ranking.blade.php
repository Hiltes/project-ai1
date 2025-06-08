<x-layouts.app :title="'Ranking Dań'">
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="sm:flex sm:items-center sm:justify-between mb-8">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-bold text-emerald-700">Ranking najlepszych dań</h1>
                    <p class="mt-2 text-sm text-gray-600">Top 10 najlepiej ocenianych dań w tym miesiącu</p>
                </div>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-2xl">
                @forelse($rankingItems as $index => $item)
                    <div onclick="window.location='{{ route('items.show', $item->id) }}';"
                        class="grid grid-cols-12 gap-4 px-6 py-4 items-center border-b border-gray-100 hover:bg-gray-50 transition duration-150 ease-in-out cursor-pointer">

                        <div class="col-span-1 text-xl font-bold text-emerald-700">
                            #{{ $index + 1 }}
                        </div>

                        {{-- Nazwa + zdjęcie --}}
                        <div class="col-span-5 md:col-span-4 flex items-center gap-4">
                            {{-- Miniaturka --}}
                            <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-lg overflow-hidden">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                         alt="{{ $item->name }}"
                                         class="object-cover w-full h-full">
                                @else
                                    <div class="flex items-center justify-center text-gray-400 text-xs w-full h-full">
                                        brak zdjęcia
                                    </div>
                                @endif
                            </div>

                            {{-- Nazwa i ocena mobilna --}}
                            <div>
                                <div class="text-lg font-semibold text-emerald-700 group-hover:text-emerald-900 group-hover:underline">
                                    {{ $item->name }}
                                </div>

                                {{-- Mobile rating --}}
                                <div class="block md:hidden text-sm text-gray-600 mt-1">
                                    <span class="font-medium text-emerald-700">Ocena:</span>
                                    {{ number_format($item->reviews_avg_rating, 1) }}/5
                                    <span class="mx-2">•</span>
                                    <span class="text-gray-500 text-xs">Opinie: {{ $item->ratings_count }}</span>
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

                        {{-- Desktop rating --}}
                        <div class="hidden md:col-span-2 md:block text-sm text-gray-700 space-y-1">
                            <div>
                                <span class="font-medium text-emerald-700">Ocena:</span>
                                {{ number_format($item->reviews_avg_rating, 1) }}/5
                            </div>
                            <div>
                                <span class="text-gray-500 text-xs">Opinie ten miesiąc: {{ $item->ratings_count }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Brak dań w rankingu</h3>
                        <p class="mt-1 text-sm text-gray-500">Brak ocen w tym miesiącu.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</x-layouts.app>
