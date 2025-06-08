<x-layouts.app :title="'Statystyki sprzedaży'">
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-emerald-700">Statystyki sprzedaży</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Łączna liczba sprzedanych dań</h2>
                <p class="text-3xl font-bold text-emerald-600">{{ $totalItemsSold }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">Łączna wartość sprzedaży</h2>
                <p class="text-3xl font-bold text-emerald-600">{{ number_format($totalSalesValue, 2, ',', ' ') }} zł</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h2 class="text-xl font-semibold mb-4">Najpopularniejsze dania (top 5)</h2>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-emerald-100">
                        <th class="py-2 px-4 text-left">Danie</th>
                        <th class="py-2 px-4 text-left">Ilość sprzedana</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topItems as $item)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $item->name }}</td>
                            <td class="py-2 px-4">{{ $item->total_quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <h2 class="text-xl font-semibold mb-4">Sprzedaż dzienna (ostatnie 7 dni)</h2>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-emerald-100">
                        <th class="py-2 px-4 text-left">Data</th>
                        <th class="py-2 px-4 text-left">Wartość sprzedaży</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesByDay as $day)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($day->date)->format('d.m.Y') }}</td>
                            <td class="py-2 px-4">{{ number_format($day->total_sales, 2, ',', ' ') }} zł</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Sprzedaż według restauracji</h2>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-emerald-100">
                        <th class="py-2 px-4 text-left">Restauracja</th>
                        <th class="py-2 px-4 text-left">Ilość sprzedanych dań</th>
                        <th class="py-2 px-4 text-left">Wartość sprzedaży</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salesByRestaurant as $restaurant)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $restaurant->restaurant_name }}</td>
                            <td class="py-2 px-4">{{ $restaurant->total_quantity }}</td>
                            <td class="py-2 px-4">{{ number_format($restaurant->total_value, 2, ',', ' ') }} zł</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
