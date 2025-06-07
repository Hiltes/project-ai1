<x-layouts.app :title="'Panel użytkownika - FoodiePlatform'">
    <section class="max-w-7xl mx-auto px-6 py-12 text-center">
        <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
            Panel użytkownika
        </h2>
        <p class="text-gray-700 text-lg">
            Witaj, {{ auth()->user()->name }}! Oto twój panel użytkownika
        </p>
    </section>

     <section class="max-w-7xl mx-auto px-6 py-6">
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
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
                <p class="text-gray-600 mb-4">Dodaj weryfikację 2-etapową przy logowaniu</p>
                <a href="{{ route('totp.show') }}" class="text-[#1fa37a] font-medium hover:underline">Dodaj weryfikację</a>
            </div>
        </div>
    </section>
</x-layouts.app>


