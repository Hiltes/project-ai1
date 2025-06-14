<x-layouts.app :title="'Panel użytkownika - FoodiePlatform'">
    <section class="max-w-7xl mx-auto px-6 py-12 text-center">
        <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
            Panel użytkownika
        </h2>
        <p class="text-gray-700 text-lg">
            Witaj, {{ auth()->user()->name }}! Oto twój panel użytkownika
        </p>
    </section>
    @if(isset($restaurantToReview))
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded-xl shadow mb-6 max-w-4xl mx-auto text-center">
         Nie zapomnij ocenić odwiedzonych restauracji!
        <a href="{{ route('reviews.restaurants.to-rate') }}" class="underline text-yellow-700 ml-2">
    Wystaw opinię
</a>

    </div>
    @endif

    <section class="max-w-7xl mx-auto px-6 py-6">
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <div class="bg-white p-6 rounded-lg shadow text-left">
                <h3 class="text-xl font-bold mb-2 text-[#1fa37a]">Zamówienia</h3>
                <p class="text-gray-600 mb-4">Sprawdź historię i status swoich zamówień.</p>
                <a href="{{ route('orders.index') }}" class="text-[#1fa37a] font-medium hover:underline">Przejdź do zamówień</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-left">
                <h3 class="text-xl font-bold mb-2 text-[#1fa37a]">Ustawienia profilu</h3>
                <p class="text-gray-600 mb-4">Edytuj swoje dane osobowe i dane kontaktowe.</p>
                <a href="{{ route('profile.edit') }}" class="text-[#1fa37a] font-medium hover:underline">Edytuj Profil</a>
            </div>
            <div class="bg-white p-6 rounded-lg shadow text-left">
                <h3 class="text-xl font-bold mb-2 text-[#1fa37a]">Weryfikacja 2-etapowa</h3>
                <p class="text-gray-600 mb-4">Dodaj weryfikację 2-etapową przy logowaniu.</p>
                <a href="{{ route('totp.show') }}" class="text-[#1fa37a] font-medium hover:underline">Dodaj weryfikację</a>
            </div>
       
            <div class="bg-white p-6 rounded-lg shadow text-left">
                <h3 class="text-xl font-bold mb-2 text-[#1fa37a]">Twoje recenzje</h3>
                <p class="text-gray-600 mb-4">Wystaw ocenę zamówionym daniom, które jeszcze nie oceniłeś.</p>
                <a href="{{ route('reviews.pending') }}" class="text-[#1fa37a] font-medium hover:underline">Oceń dania</a>
            </div>

                <div class="bg-white p-6 rounded-lg shadow text-left">
                <h3 class="text-xl font-bold mb-2 text-[#1fa37a]">Oceń restauracje</h3>
                <p class="text-gray-600 mb-4">Podziel się opinią o restauracjach, w których składałeś zamówienia.</p>
                <a href="{{ route('reviews.restaurants.to-rate') }}" class="text-[#1fa37a] font-medium hover:underline">Oceń restauracje</a>
            </div>
        </div>
    </section>
</x-layouts.app>
