<x-layouts.app :title="'Szczegóły zamówienia #' . $order->id">
    <main class="flex-grow">
        <div class="max-w-4xl mx-auto px-6 py-12">
            <h2 class="text-3xl font-bold text-emerald-700 mb-6">Szczegóły zamówienia #{{ $order->id }}</h2>

            <div class="bg-white shadow-md rounded-2xl p-8 space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Klient:</h3>
                    <p class="text-gray-900">{{ $order->customer->name }} ({{ $order->customer->email }})</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Restauracja:</h3>
                    <p class="text-gray-900">{{ $order->restaurant->name }}</p>
                </div>

                @php
                    $statusLabels = [
                        'pending' => 'Oczekujące',
                        'in_progress' => 'W realizacji',
                        'delivered' => 'Dostarczone',
                        'cancelled' => 'Anulowane',
                    ];
                @endphp
  
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Status:</h3>
                    <p class="text-gray-900 capitalize">{{ $statusLabels[$order->status] ?? $order->status }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Adres dostawy:</h3>
                    <p class="text-gray-900">{{ $order->delivery_address }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Data zamówienia:</h3>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($order->order_date)->format('d.m.Y') }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Pozycje zamówienia:</h3>
                    @if($order->items->count())
                        <ul class="list-disc list-inside text-gray-900">
                            @foreach($order->items as $item)
                                <li>{{ $item->menuItem->name }} × {{ $item->quantity }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Brak pozycji w zamówieniu.</p>
                    @endif
                </div>

                <div class="pt-4">
                    <a href="{{ route('admin.orders.edit', $order) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                        Edytuj zamówienie
                    </a>
                    <a href="{{ route('admin.orders.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-emerald-500 rounded-xl shadow-sm text-sm font-medium text-emerald-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                        Wróć do listy zamówień
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app>
