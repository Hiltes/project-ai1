<x-layouts.app :title="'Edycja Zamówienia'">
    <div class="max-w-3xl mx-auto py-12">
        <h1 class="text-3xl font-bold text-emerald-700 mb-6">Edycja Zamówienia #{{ $order->id }}</h1>

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-200 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Klient</label>
                <input type="text" disabled 
                    value="{{ $order->customer->name }} ({{ $order->customer->email }}"
                    class="w-full mt-1 rounded-xl border-gray-300 bg-gray-100 cursor-not-allowed" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Restauracja</label>
                <input type="text" disabled 
                    value="{{ $order->restaurant?->name ?? 'Brak restauracji' }}"
                    class="w-full mt-1 rounded-xl border-gray-300 bg-gray-100 cursor-not-allowed" />
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" required
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="pending" @selected($order->status === 'pending')>Oczekujące</option>
                    <option value="in_progress" @selected($order->status === 'in_progress')>W realizacji</option>
                    <option value="delivered" @selected($order->status === 'delivered')>Dostarczone</option>
                    <option value="cancelled" @selected($order->status === 'cancelled')>Anulowane</option>
                </select>
            </div>
            <div>
                <label for="delivery_address" class="block text-sm font-medium text-gray-700">Adres dostawy</label>
                <input type="text" name="delivery_address" id="delivery_address" required
                    value="{{ old('delivery_address', $order->delivery_address) }}"
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500" />
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4">Pozycje zamówienia</h3>
                <div id="order-items-container" class="space-y-4"></div>

                <button type="button" id="add-order-item"
                    class="mt-4 inline-flex items-center text-emerald-600 font-semibold hover:underline">
                    <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4" />
                    </svg>
                    Dodaj kolejną pozycję
                </button>
            </div>

            {{-- Submit --}}
            <div class="pt-5">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    Zapisz zmiany
                </button>
            </div>
        </form>
    </div>

    <script>
        const menuItems = @json($menuItems);
        const restaurantSelectValue = "{{ $order->restaurant_id }}";
        const orderItemsContainer = document.getElementById('order-items-container');
        const addOrderItemBtn = document.getElementById('add-order-item');
        let itemIndex = 0;

        const existingOrderItems = @json($order->items ?? []);

        function createMenuItemSelect(index, restaurantId, selectedMenuItemId = null) {
            const select = document.createElement('select');
            select.name = `items[${index}][menu_item_id]`;
            select.required = true;
            select.className = 'rounded-xl border-gray-300 w-full';

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Wybierz danie';
            defaultOption.disabled = true;
            defaultOption.selected = selectedMenuItemId === null;
            select.appendChild(defaultOption);

            if (!restaurantId) {
                return select;
            }

            const filteredItems = menuItems.filter(item => item.restaurant_id == restaurantId);

            filteredItems.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                const price = Number(item.price);
                option.textContent = `${item.name} (${isNaN(price) ? '0.00' : price.toFixed(2)} zł)`;
                if (selectedMenuItemId && item.id === selectedMenuItemId) {
                    option.selected = true;
                }
                select.appendChild(option);
            });

            if(filteredItems.length === 0) {
                const noItemsOption = document.createElement('option');
                noItemsOption.value = '';
                noItemsOption.textContent = 'Brak dań dla tej restauracji';
                noItemsOption.disabled = true;
                select.appendChild(noItemsOption);
            }

            return select;
        }

        function createQuantityInput(index, value = 1) {
            const input = document.createElement('input');
            input.type = 'number';
            input.name = `items[${index}][quantity]`;
            input.min = 1;
            input.value = value;
            input.required = true;
            input.className = 'w-20 rounded-xl border-gray-300 text-center';
            return input;
        }

        function createOrderItemRow(index, restaurantId, selectedMenuItemId = null, quantity = 1) {
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-4 mt-4';

            const menuItemSelect = createMenuItemSelect(index, restaurantId, selectedMenuItemId);
            const quantityInput = createQuantityInput(index, quantity);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.textContent = 'Usuń';
            removeBtn.className = 'ml-2 px-3 py-1 rounded-xl bg-red-600 text-white hover:bg-red-700 transition';
            removeBtn.addEventListener('click', () => {
                div.remove();
            });

            div.appendChild(menuItemSelect);
            div.appendChild(quantityInput);
            div.appendChild(removeBtn);

            return div;
        }

        function resetOrderItems() {
            orderItemsContainer.innerHTML = '';
            itemIndex = 0;
        }

        addOrderItemBtn.addEventListener('click', () => {
            if (!restaurantSelectValue) {
                alert('Najpierw wybierz restaurację!');
                return;
            }
            const newRow = createOrderItemRow(itemIndex, restaurantSelectValue);
            orderItemsContainer.appendChild(newRow);
            itemIndex++;
        });

        window.addEventListener('DOMContentLoaded', () => {
            if (!restaurantSelectValue) return;

            existingOrderItems.forEach(item => {
                const row = createOrderItemRow(itemIndex, restaurantSelectValue, item.menu_item_id, item.quantity);
                orderItemsContainer.appendChild(row);
                itemIndex++;
            });
        });
    </script>
</x-layouts.app>
