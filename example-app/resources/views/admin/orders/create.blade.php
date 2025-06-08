<x-layouts.app :title="'Dodaj Zamówienie'">
    <main class="flex-grow">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-emerald-700 mb-6">Dodaj nowe zamówienie</h1>

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-200 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.orders.store') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Klient</label>
                    <select name="user_id" id="user_id" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Wybierz użytkownika</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="restaurant_id" class="block text-sm font-medium text-gray-700">Restauracja</label>
                    <select name="restaurant_id" id="restaurant_id" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Wybierz restaurację</option>
                        @foreach($restaurants as $restaurant)
                            <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="delivery_address" class="block text-sm font-medium text-gray-700">Adres dostawy</label>
                    <input type="text" name="delivery_address" id="delivery_address" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="pending">Oczekujące</option>
                        <option value="in_progress">W realizacji</option>
                        <option value="delivered">Dostarczone</option>
                        <option value="cancelled">Anulowane</option>
                    </select>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mt-6 mb-2">Pozycje zamówienia</h3>
                    <div id="order-items-container" class="space-y-4"></div>
                    <button type="button" id="add-order-item"
                        class="mt-3 inline-flex items-center text-emerald-600 font-semibold hover:underline">
                        <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Dodaj kolejną pozycję
                    </button>
                </div>

                <div class="pt-5">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-xl font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Zapisz zamówienie
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const menuItems = @json($menuItems);
        const restaurantSelect = document.getElementById('restaurant_id');
        const orderItemsContainer = document.getElementById('order-items-container');
        const addOrderItemBtn = document.getElementById('add-order-item');
        let itemIndex = 0;

        function getSelectedMenuItemIds() {
            const selects = document.querySelectorAll('#order-items-container select[name$="[menu_item_id]"]');
            const ids = [];
            selects.forEach(sel => {
                if(sel.value) {
                    ids.push(sel.value);
                }
            });
            return ids;
        }

        function createMenuItemSelect(index, restaurantId) {
            const select = document.createElement('select');
            select.name = `items[${index}][menu_item_id]`;
            select.required = true;
            select.className = 'rounded-xl border-gray-300 w-full';

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Wybierz danie';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            select.appendChild(defaultOption);

            if (!restaurantId) {
                return select;
            }

            const restaurantIdNum = parseInt(restaurantId);
            const selectedIds = getSelectedMenuItemIds();

            const filteredItems = menuItems.filter(item => item.restaurant_id === restaurantIdNum);

            if (filteredItems.length === 0) {
                const noItemsOption = document.createElement('option');
                noItemsOption.value = '';
                noItemsOption.textContent = 'Brak dań dla tej restauracji';
                noItemsOption.disabled = true;
                select.appendChild(noItemsOption);
                return select;
            }

            filteredItems.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = `${item.name} (${Number(item.price).toFixed(2)} zł)`;

                if(selectedIds.includes(String(item.id))) {
                    option.disabled = true;
                }

                select.appendChild(option);
            });

            select.addEventListener('change', () => {
                refreshMenuItemSelects();
            });

            return select;
        }

        function createQuantityInput(index) {
            const input = document.createElement('input');
            input.type = 'number';
            input.name = `items[${index}][quantity]`;
            input.min = 1;
            input.value = 1;
            input.required = true;
            input.className = 'w-20 rounded-xl border-gray-300 text-center';
            return input;
        }

        function createOrderItemRow(index) {
            const div = document.createElement('div');
            div.className = 'flex items-center space-x-4 mt-4';

            const restaurantId = restaurantSelect.value;

            const menuItemSelect = createMenuItemSelect(index, restaurantId);
            const quantityInput = createQuantityInput(index);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.textContent = 'Usuń';
            removeBtn.className = 'ml-2 px-3 py-1 rounded-xl bg-red-600 text-white hover:bg-red-700 transition';
            removeBtn.addEventListener('click', () => {
                div.remove();
                refreshMenuItemSelects();
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
            if (!restaurantSelect.value) {
                return;
            }
            const newRow = createOrderItemRow(itemIndex);
            orderItemsContainer.appendChild(newRow);
            itemIndex++;
            refreshMenuItemSelects();
        });

        restaurantSelect.addEventListener('change', () => {
            resetOrderItems();
        });

        function refreshMenuItemSelects() {
            const selects = document.querySelectorAll('#order-items-container select[name$="[menu_item_id]"]');
            selects.forEach(sel => {
                const restaurantId = restaurantSelect.value;
                const currentValue = sel.value;

                while(sel.firstChild) sel.removeChild(sel.firstChild);

                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Wybierz danie';
                defaultOption.disabled = true;
                defaultOption.selected = !currentValue;
                sel.appendChild(defaultOption);

                const selectedIds = getSelectedMenuItemIds().filter(id => id !== currentValue);

                const filteredItems = menuItems.filter(item => item.restaurant_id === parseInt(restaurantId));

                filteredItems.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = `${item.name} (${Number(item.price).toFixed(2)} zł)`;

                    if(selectedIds.includes(String(item.id))) {
                        option.disabled = true;
                    }
                    sel.appendChild(option);
                });

                if(currentValue) {
                    sel.value = currentValue;
                }
            });
        }
    </script>
</x-layouts.app>
