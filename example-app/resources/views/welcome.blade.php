<x-layouts.app>
    <main class="container mx-auto px-4 py-12">
        <section class="text-center max-w-4xl mx-auto mb-12">
            <h2 class="text-4xl font-extrabold mb-4 text-green-600">
                Zamawiaj jedzenie z najlepszych restauracji
            </h2>
            <p class="text-gray-700 text-lg">
                Platforma do zamawiania pysznego jedzenia w Twojej okolicy.
            </p>
        </section>

        <section>
            <h3 class="text-2xl font-bold mb-6">Dostępne restauracje</h3>
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($restaurants as $restaurant)
                    @include('components.restaurant-card', ['restaurant' => $restaurant])
                @endforeach
            </div>
        </section>
    </main>
</x-layouts.app>
