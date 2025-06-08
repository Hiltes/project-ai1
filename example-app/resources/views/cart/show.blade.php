<x-layouts.app :title="'FoodiePlatform - Koszyk'">
    <main class="flex-grow">
        <section class="max-w-7xl mx-auto px-6 py-12 text-center">
            <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
                Twój koszyk
            </h2>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-200 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if (empty($cart['restaurants']))
                <p class="text-gray-700 text-lg">Twój koszyk jest pusty.</p>
            @else
                <div class="bg-white rounded shadow p-6 max-w-3xl mx-auto">
                    @foreach ($cart['restaurants'] as $restaurantId => $restaurant)
                        <div class="mb-8 border-b pb-6">
                            <h3 class="font-bold text-xl mb-4">{{ $restaurant['restaurant_name'] }}</h3>

                            <ul class="divide-y divide-gray-200">
                                @foreach ($restaurant['items'] as $id => $item)
                                    <li class="flex justify-between items-center py-4">
                                        <div>
                                            <h4 class="font-semibold text-lg">{{ $item['name'] }}</h4>
                                            <p class="text-gray-600">Ilość: {{ $item['quantity'] }}</p>
                                            <p class="text-gray-600">Cena za sztukę: {{ number_format($item['price'], 2, ',', ' ') }} zł</p>
                                        </div>
                                        <form action="{{ route('cart.remove', ['restaurantId' => $restaurantId, 'menuItemId' => $id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                                Usuń
                                            </button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-4 text-right font-semibold">
                                Suma dla tej restauracji: {{ number_format(array_reduce($restaurant['items'], fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0), 2, ',', ' ') }} zł
                            </div>
                            <div class="mt-1 text-right text-gray-600">
                                Opłata za dowóz: {{ number_format($restaurant['delivery_fee'] ?? 0, 2, ',', ' ') }} zł
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-6 text-right font-bold text-xl">
                        Suma całkowita: {{ number_format($total, 2, ',', ' ') }} zł
                    </div>
                    <div class="mt-1 text-right text-gray-600">
                        W tym za dostawe: {{ number_format(array_sum(array_map(fn($r) => $r['delivery_fee'] ?? 0, $cart['restaurants'])), 2, ',', ' ') }} zł
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <form action="{{ route('cart.clear') }}" method="POST" class="">
                            @csrf
                            <button type="submit" class="bg-gray-700 hover:bg-gray-900 text-white px-4 py-2 rounded">
                                Wyczyść koszyk
                            </button>
                        </form>

                        <button onclick="document.getElementById('order-form').style.display='block'; this.style.display='none';" 
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded">
                            Zamów wszystko
                        </button>
                    </div>

                    <form method="POST" action="{{ route('order.place') }}" id="order-form" style="display:none;" class="mt-6 max-w-md mx-auto text-left">
                        @csrf

                        <label for="delivery_address" class="block font-semibold mb-2">Adres dostawy</label>
                        <input
                            id="delivery_address"
                            name="delivery_address"
                            type="text"
                            required
                            minlength="5"
                            maxlength="255"
                            value="{{ old('delivery_address', auth()->user()->address ?? '') }}"
                            class="w-full border border-gray-300 rounded px-3 py-2 mb-4"
                            placeholder="Wpisz adres dostawy"
                        >
                        @error('delivery_address')
                            <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
                        @enderror

                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="document.getElementById('order-form').style.display='none'; document.querySelector('button.bg-emerald-600').style.display='inline-block';" 
                                class="px-4 py-2 rounded border border-gray-400">
                                Anuluj
                            </button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded">
                                Potwierdź i zamów
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </section>
    </main>
</x-layouts.app>
