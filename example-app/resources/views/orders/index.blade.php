<x-layouts.app :title="'Moje Zamówienia'">
<main class="flex-grow max-w-5xl mx-auto px-4 py-12">

    <h1 class="text-3xl font-bold mb-8 text-emerald-700">Twoje zamówienia</h1>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="tabs">

        <input type="radio" id="tab1" name="tab" checked class="hidden" />
        <label for="tab1" class="cursor-pointer inline-block px-6 py-2 rounded-t-lg border border-b-0 border-gray-300 hover:bg-gray-100">Aktywne</label>

        <input type="radio" id="tab2" name="tab" class="hidden" />
        <label for="tab2" class="cursor-pointer inline-block px-6 py-2 rounded-t-lg border border-b-0 border-gray-300 hover:bg-gray-100">Historia</label>

        <div class="tab-content border border-gray-300 p-6 rounded-b-lg">

            <section id="content1" class="tab-panel">
                @if ($activeOrders->isEmpty())
                    <p>Brak aktywnych zamówień.</p>
                @else
                    <div class="space-y-6 max-h-[600px] overflow-y-auto pr-4">
                        @foreach ($activeOrders as $order)
                            <div class="p-6 bg-white rounded shadow">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-semibold text-emerald-800">Zamówienie #{{ $order->id }} - {{ $order->restaurant->name ?? 'Brak restauracji' }}</h3>
                                    <span class="text-sm font-medium text-gray-600">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                                </div>

                                <div>
                                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                                    <p><strong>Adres dostawy:</strong> {{ $order->delivery_address }}</p>
                                </div>

                                <div class="mt-4">
                                    <h4 class="font-semibold mb-2">Pozycje:</h4>
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
                    </div>
                @endif
            </section>

            <section id="content2" class="tab-panel hidden">
                @if ($pastOrders->isEmpty())
                    <p>Brak zakończonych zamówień.</p>
                @else
                    <div class="space-y-6 max-h-[600px] overflow-y-auto pr-4">
                        @foreach ($pastOrders as $order)
                            <div class="p-6 bg-white rounded shadow">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-xl font-semibold text-emerald-800">Zamówienie #{{ $order->id }} - {{ $order->restaurant->name ?? 'Brak restauracji' }}</h3>
                                    <span class="text-sm font-medium text-gray-600">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                                </div>

                                <div>
                                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                                    <p><strong>Adres dostawy:</strong> {{ $order->delivery_address }}</p>
                                </div>

                                <div class="mt-4">
                                    <h4 class="font-semibold mb-2">Pozycje:</h4>
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
                    </div>
                @endif
            </section>

        </div>
    </div>

</main>

<style>
    .tab-panel {
        display: none;
    }
    #tab1:checked ~ .tab-content #content1 {
        display: block;
    }
    #tab2:checked ~ .tab-content #content2 {
        display: block;
    }
    input[type="radio"]:checked + label {
        background-color: #1fa37a;
        color: white;
        border-bottom: 2px solid white;
        font-weight: 700;
    }
</style>
</x-layouts.app>
