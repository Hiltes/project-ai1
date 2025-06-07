<x-layouts.app :title="'Moje Zamówienia'">
    <main class="flex-grow max-w-5xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold mb-8 text-emerald-700">Twoje zamówienia</h1>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($orders->isEmpty())
            <p>Nie złożyłeś jeszcze żadnego zamówienia.</p>
        @else
            @foreach ($orders as $order)
                <div class="mb-6 p-6 bg-white rounded shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-emerald-800">Zamówienie #{{ $order->id }} - {{ $order->restaurant->name ?? 'Brak restauracji' }}</h2>
                        <span class="text-sm font-medium text-gray-600">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                    </div>

                    <div>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p><strong>Adres dostawy:</strong> {{ $order->delivery_address }}</p>
                    </div>

                    <div class="mt-4">
                        <h3 class="font-semibold mb-2">Pozycje:</h3>
                        <ul class="list-disc list-inside">
                            @foreach ($order->items as $item)
                                <li>
                                    {{ $item->menuItem->name ?? 'Brak dania' }} — Ilość: {{ $item->quantity }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        @endif
    </main>
</x-layouts.app>
