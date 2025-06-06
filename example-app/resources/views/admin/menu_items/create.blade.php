<x-layouts.app :title="'Dodaj Danie'">
    <main class="flex-grow">
        <section class="max-w-7xl mx-auto px-6 py-12 text-center">
            <h2 class="text-4xl font-extrabold mb-4" style="color: #1fa37a;">
                Panel administratora
            </h2>
            <p class="text-gray-700 text-lg">
                Witaj, {{ auth()->user()->name }}! Masz dostęp do zarządzania platformą.
            </p>
        </section>

        <section class="max-w-7xl mx-auto px-6 py-6 text-left">
            <form method="POST" action="{{ route('admin.menu_items.store') }}"
                class="bg-white shadow-md rounded-2xl p-8 space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-800">Nazwa dania</label>
                    <input id="name" name="name" type="text" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-800">Opis</label>
                    <textarea id="description" name="description" rows="4"
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition"></textarea>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-800">Cena (zł)</label>
                    <input id="price" name="price" type="number" step="0.01" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div>
                    <label for="restaurant_id" class="block text-sm font-medium text-gray-800">ID restauracji</label>
                    <input id="restaurant_id" name="restaurant_id" type="number" required
                        class="mt-1 block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-base shadow-sm focus:ring-2 focus:ring-[#1fa37a] focus:border-[#1fa37a] focus:bg-white transition">
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="bg-[#1fa37a] text-white font-semibold px-6 py-3 rounded-xl hover:bg-[#178a66] transition duration-200 shadow-md">
                        Zapisz
                    </button>
                </div>
            </form>

        </section>
    </main>

</x-layouts.app>
