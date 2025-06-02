<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>FoodiePlatform - Koszyk</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 font-sans">

    @include('components.header')

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
                </div>
            @endforeach

            <div class="mt-6 text-right font-bold text-xl">
                Suma całkowita: {{ number_format($total, 2, ',', ' ') }} zł
            </div>

                <form action="{{ route('cart.clear') }}" method="POST" class="mt-6 text-right">
                    @csrf
                    <button type="submit" class="bg-gray-700 hover:bg-gray-900 text-white px-4 py-2 rounded">
                        Wyczyść koszyk
                    </button>
                </form>
            </div>
        @endif
    </section>

    @include('components.footer')

</body>
</html>
