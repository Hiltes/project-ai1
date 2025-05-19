<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>FoodiePlatform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 font-sans">

    @include('components.header')

    <section class="max-w-7xl mx-auto px-6 py-12 text-center">
        <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
            Zamawiaj jedzenie z najlepszych restauracji
        </h2>
        <p class="text-gray-700 text-lg">
            Platforma do zamawiania pysznego jedzenia w Twojej okolicy.
        </p>
    </section>

    <section class="max-w-7xl mx-auto px-6 py-6">
        <h3 class="text-2xl font-bold mb-6">Dostępne restauracje</h3>
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($restaurants as $restaurant)
                @include('components.restaurant-card', ['restaurant' => $restaurant])
            @endforeach
        </div>
    </section>

    @include('components.footer')

</body>
</html>
