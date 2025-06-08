<x-layouts.app>
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow p-6 mt-8">
        <h1 class="text-2xl font-bold mb-4 text-[#1fa37a]">Szczegóły restauracji</h1>

        <div class="space-y-4 text-gray-800">
            <div>
                <strong class="text-[#1fa37a]">Nazwa:</strong> {{ $restaurant->name }}
            </div>
            <div>
                <strong class="text-[#1fa37a]">Opis:</strong> {{ $restaurant->description ?? '—' }}
            </div>
            <div>
                <strong class="text-[#1fa37a]">Adres:</strong> {{ $restaurant->address }}
            </div>
            <div>
                <strong class="text-[#1fa37a]">Telefon:</strong> {{ $restaurant->phone ?? '—' }}
            </div>
            <div>
                <strong class="text-[#1fa37a]">Typ kuchni:</strong> {{ $restaurant->type }}
            </div>
            <div>
                <strong class="text-[#1fa37a]">Opłata za dostawę:</strong> 
                {{ $restaurant->delivery_fee ? number_format($restaurant->delivery_fee, 2) . ' zł' : '—' }}
            </div>
            <div>
                <strong class="text-[#1fa37a]">Aktywna:</strong> 
                <span class="{{ $restaurant->is_active ? 'text-green-600' : 'text-red-600' }}">
                    {{ $restaurant->is_active ? 'Tak' : 'Nie' }}
                </span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.restaurants.index') }}"
               class="inline-block px-4 py-2 bg-[#1fa37a] text-white rounded hover:bg-[#178f69] text-sm">
                ← Powrót
            </a>
        </div>
    </div>
</x-layouts.app>
