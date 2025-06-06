<x-layouts.app :title="'Edytuj Danie'">

    <main class="flex-grow">
        <section class="max-w-7xl mx-auto px-6 py-12 text-center">
            <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
                Edycja dania
            </h2>
            <p class="text-gray-700 text-lg">
                Wprowadź zmiany w wybranym daniu: <strong>{{ $menuItem->name }}</strong>
            </p>
        </section>

        <section class="max-w-4xl mx-auto px-6 py-6 text-left">
            <form method="POST" action="{{ route('admin.menu_items.update', $menuItem) }}"
                class="bg-white shadow-md rounded-2xl p-8 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-800">Nazwa dania</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $menuItem->name) }}"
                        required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-800">Opis</label>
                    <textarea id="description" name="description" rows="4"
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">{{ old('description', $menuItem->description) }}</textarea>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-800">Cena (zł)</label>
                    <input id="price" name="price" type="number" step="0.01"
                        value="{{ old('price', $menuItem->price) }}" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="restaurant_id" class="block text-sm font-medium text-gray-800">ID restauracji</label>
                    <input id="restaurant_id" name="restaurant_id" type="number"
                        value="{{ old('restaurant_id', $menuItem->restaurant_id) }}" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="bg-[#1fa37a] text-white font-semibold px-6 py-3 rounded-xl hover:bg-[#178a66] transition duration-200 shadow-md">
                        Zapisz zmiany
                    </button>
                </div>
            </form>
        </section>
    </main>

</x-layouts.app>
